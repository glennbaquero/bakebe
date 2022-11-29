<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoices\Invoice;
use App\Traits\ImageTrait;
use App\Traits\DateTrait;
use App\Traits\NumberFormatTrait;

use App\Models\Branches\Branch;

use Carbon\Carbon;

class InvoiceItem extends Model
{
	use DateTrait, NumberFormatTrait, ImageTrait;

    protected $guarded = [];
    
    protected $appends = ['formatted_schedule', 'formatted_time', 'pastry_image', 'pastry_name', 'pastry_duration', 'pastry_difficulty'];

    protected $casts = [
    	'promo_data' => 'array',
    	'cart_item_data' => 'array',
    	'pastry_data' => 'array',
    ];

    /*
     * Relationship
     */
    
    public function invoice() {
    	return $this->belongsTo(Invoice::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    /*
     * Renderers
     */
    
    /**
     * render the duration of reservation based on duration of pastry and user inputted time slot for their reservation 
     *
     * @return string
     */
    public function getReservationTime() {
        $pastry_duration = json_decode($this->pastry_data)->duration / 60;
        $end_time = Carbon::parse($this->start_time)->addHours($pastry_duration)->format('g:i A');
        $result = $this->formatted_time. ' to '. $end_time;
        return $result;
    }

    public function parseData($column) {
        return json_decode($column);
    }

    public function renderAmountWithFormat($amount) {
        return '₱ ' .number_format($amount, 2, '.', ',');
    }

    public function renderEncodedPastry() {
        $item = json_decode($this->pastry_data);

        return $item;
    }

    /**
     * Render pastry data image
     *
     * @return string
     */
    public function getPastryImage($path) {
        $image_src = $this->getImageUrl($path);
        return $image_src;
    }
    
    /*
     * Append Data
     */
    
    public function getFormattedScheduleAttribute() {
        return Carbon::parse($this->scheduled_date)->format('M. d, Y');
    }

    public function getFormattedTimeAttribute() {
        return Carbon::parse($this->start_time)->format('H:i A');
    }

    public function getPastryImageAttribute() {
        return url('storage/'.json_decode($this->pastry_data)->image_path);
    }

    public function getPastryNameAttribute() {
        $item = json_decode($this->pastry_data)->name; 
        return $item;
    }    

    public function getPastryDurationAttribute() {
        $duration = json_decode($this->pastry_data)->duration; 

        if ($duration < 1) {
            return '---';
        }

        $hours = floor($duration / 60);
        $minutes = ($duration % 60);

        $minute_format = null;
        $hours_format = null;

        if($hours > 1) {
            $hours_format = $hours.' hours';
        } elseif ($hours <= 1 && $hours  != 0) {
            $hours_format = $hours.' hour';
        }

        if($minutes > 1) {
            $minute_format = $minutes.' minutes';
        } elseif ($minutes <= 1 && $minutes  != 0) {
            $minute_format = $minutes.' minute';
        }

        $result = $hours_format.' '.$minute_format;

        return $result;                   
    }    

    public function getPastryDifficultyAttribute() {
        $item = json_decode($this->pastry_data)->difficulty; 
        return $item;
    }    

    public function renderMarkAsClaimedUrl() {
        return route('admin.invoice-items.mark-as-claimed', $this->id);
    }

    public function renderClaimedStatus() {
        $label = $this->is_claim ? 'Claimed' : 'Unclaimed'; 
        return $label;
    }

}