<?php

namespace App\Models\Pastries;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Branches\Branch;
use App\Models\Carts\CartItem;

use App\Traits\ImageTrait;

class Pastry extends Model
{

    use ImageTrait;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /*
	 * Relationship
	 */
	
	public function category() {
		return $this->belongsTo(Category::class)->withTrashed();
	}

    public function branches() {
        return $this->belongsToMany(Branch::class, 'pastries_branches', 'pastry_id', 'branch_id');
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class); 

    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'difficulty' => $this->difficulty,
            'name' => $this->name,
            'duration' => $this->duration,
        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'category_id', 'difficulty', 'duration', 'description', 'express_duration', 'express_amount', 'regular_amount', 'additional_regular_amount', 'additional_express_amount'])
    {
        $vars = $request->only($columns);
        $vars['is_active'] = $request->is_active ? 1 : 0;
        $vars['is_available_express'] = $request->is_available_express ? 1 : 0;
        $vars['is_available_regular'] = $request->is_available_regular ? 1 : 0;

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'pastries');
        }

        return $item;
    }


    /*
     * Getters
     */
    
    public static function getActive() {
        return [
            ['value' => static::ACTIVE, 'label' => 'ACTIVE', 'class' => 'bg-success'],
            ['value' => static::INACTIVE, 'label' => 'INACTIVE', 'class' => 'bg-danger'],
        ];
    }

    /**
     * @Render
     */
    
    public function renderActiveLabel() {
        return $this->renderConstants(static::getActive(), $this->is_active, 'label');
    }

    public function renderActiveClass() {
        return $this->renderConstants(static::getActive(), $this->is_active, 'class');
    }

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.pastries.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.pastries.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.pastries.restore', $this->id);
    }

    public function convertToHoursMins($duration) {
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
}
