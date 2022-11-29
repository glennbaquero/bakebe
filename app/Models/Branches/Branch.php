<?php

namespace App\Models\Branches;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Pastries\Pastry;
use App\Models\Invoices\InvoiceItem;
use App\Models\Invoices\Invoice;
use App\Models\Intervals\BlockDateInterval;
use App\Models\Carts\Cart;

use Carbon\Carbon;

class Branch extends Model
{
    /*
	 * Relationship
	 */
	
	public function pastries() {
		return $this->belongsToMany(Pastry::class, 'pastries_branches', 'branch_id', 'pastry_id');
	}

    public function blockDateIntervals() {
        return $this->belongsToMany(BlockDateInterval::class, 'branches_block_date_intervals', 'branch_id', 'block_date_id')->withTrashed();
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }    

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }    

    public function invoiceItems() {
        return $this->hasMany(InvoiceItem::class);
    }    

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'available_oven' => $this->available_oven,
            'contact_number' => $this->contact_number,
            'contact_email' => $this->contact_email,

        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'available_oven','work_start','work_end','location', 'longitude', 'latitude', 'contact_number','contact_email'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

    public static function getPositionByAddress($address) {
        $lat = null;
        $lng = null;

        $string = str_replace (" ", "+", urlencode($address));
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?';
        $url .= "address={$string}";
        $url .= '&components=country:PH';
        $url .= '&sensor=true';
        $url .= '&key=AIzaSyBdZmifNZogZcfRQ-wZy0B7yVVTd0cvPm4';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        if ($response['status'] == 'OK') {
            $lat = $response['results'][0]['geometry']['location']['lat'];
            $lng = $response['results'][0]['geometry']['location']['lng'];
            $message = 'You have successfully fetch the address position.';
        } else {
            $message = $response['status'];
        }

        return [
            'latitude' => $lat,
            'longitude' => $lng,
            'message' => $message,
        ];
    }

    /**
     * @Render
     */

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.branches.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.branches.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.branches.restore', $this->id);
    }
}
