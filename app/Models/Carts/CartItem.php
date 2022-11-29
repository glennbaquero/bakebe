<?php

namespace App\Models\Carts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pastries\Pastry;

use Carbon\Carbon;

class CartItem extends Model
{
    protected $guarded = [];

    protected $appends = ['formatted_schedule', 'formatted_time', 'pastry_image', 'pastry_name', 'pastry_duration', 'pastry_difficulty'];

    /*
	 * Relationship
	 */

    public function cart() {
    	return $this->belongsTo(Cart::class);
    }

    public function pastry() {
    	return $this->belongsTo(Pastry::class)->withTrashed();
    }

    /*
	 * Renderers
	 */

    /**
     * Remove item in cart
     *
     * @return string
     */
    
    public function renderRemoveItem() {
    	return route('web.cart.remove-item', $this->id);
    }

    public function renderUpdateItem() {
        return route('web.cart.update-item', $this->id);
    }

    /**
     * render the duration of reservation based on duration of pastry and user inputted time slot for their reservation 
     *
     * @return string
     */
    public function getReservationTime() {
        $pastry_duration = $this->pastry->duration / 60;
        $end_time = Carbon::parse($this->start_time)->addHours($pastry_duration)->format('g:i A');
        $result = $this->formatted_time. ' to '. $end_time;
        return $result;
    }

    /*
	 * Append Data
	 */
	
    public function getFormattedScheduleAttribute() {
        return Carbon::parse($this->scheduled_date)->format('M. d, Y');
    }

    public function getFormattedTimeAttribute() {
        return Carbon::parse($this->start_time)->format('g:i A');
    }

    /*
     * Getters
     */
    
    public function getPastryData() {
        $data['id'] = $this->pastry->id;
        $data['name'] = $this->pastry->name;
        $data['category'] = $this->pastry->category->name;
        $data['category_id'] = $this->pastry->category->id;
        $data['difficulty'] = $this->pastry->difficulty;
        $data['description'] = $this->pastry->description;
        $data['duration_label'] = $this->pastry->convertToHoursMins($this->pastry->duration);
        $data['duration'] = $this->pastry->duration;
        $data['express_duration'] = $this->pastry->express_duration;
        $data['express_duration'] = $this->pastry->convertToHoursMins($this->pastry->express_duration);
        $data['image_path'] = $this->pastry->renderImagePath();
        $data['created_at'] = $this->pastry->renderDate();

        return $data;
    }

    public function getPastryImageAttribute() {
        return $this->pastry->renderImagePath();
    }

    public function getPastryNameAttribute() {
        $item = $this->pastry->name; 
        return $item;
    }    

    public function getPastryDurationAttribute() {
        $duration = $this->pastry->duration; 

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
        $item = $this->pastry->difficulty; 
        return $item;
    }
}
