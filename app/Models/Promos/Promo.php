<?php

namespace App\Models\Promos;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Carts\Cart;

use App\Traits\HelperTrait;
use App\Traits\ImageTrait;

class Promo extends Model
{
    use HelperTrait, ImageTrait;

    protected $appends = ['img_src'];

    const ACTIVE = 1;
    const INACTIVE = 0;

    const PERCENTAGE = 1;
    const WHOLE_AMOUNT = 0;

    /*
	 * Relationship
	 */
	
	public function promoCategory() {
		return $this->belongsTo(PromoCategory::class)->withTrashed();
	}

    public function carts() {
        return $this->hasMany(Cart::class);
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
            'rate' => $this->rate,
        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['promo_category_id', 'name', 'description', 'discount', 'is_percentage'])
    {
        $vars = $request->only($columns);
        $vars['is_active'] = $request->is_active ? 1 : 0;

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'promos');
        }

        return $item;
    }

    /*
     * Getters
     */
    
    public static function getStatus() {
        return [
            ['value' => static::ACTIVE, 'label' => 'ACTIVE', 'class' => 'bg-success'],
            ['value' => static::INACTIVE, 'label' => 'INACTIVE', 'class' => 'bg-danger'],
        ];
    }

    public static function getDiscountType() {
        return [
            ['value' => static::PERCENTAGE, 'label' => 'PERCENTAGE', 'class' => 'bg-primary'],
            ['value' => static::WHOLE_AMOUNT, 'label' => 'WHOLE AMOUNT', 'class' => 'bg-success'],
        ];
    }

    /**
     * @Render
     */

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.promos.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.promos.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.promos.restore', $this->id);
    }

    public function renderStatusLabel() {
        return $this->renderConstants(static::getStatus(), $this->is_active, 'label');
    }

    public function renderStatusClass() {
        return $this->renderConstants(static::getStatus(), $this->is_active, 'class');
    }

    public function renderDiscountTypeLabel() {
        return $this->renderConstants(static::getDiscountType(), $this->is_percentage, 'label');
    }

    public function renderDiscountTypeClass() {
        return $this->renderConstants(static::getDiscountType(), $this->is_percentage, 'class');
    }

    /*
     * Append Data
     */
    
    public function getImgSrcAttribute() {
        return $this->renderImagePath();
    }
}
