<?php

namespace App\Models\Promos;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Coupons\Coupon;

class PromoCategory extends Model
{
    /*
	 * Relationship
	 */
	
	public function promos() {
		return $this->hasMany(Promo::class);
	}

    public function coupons() {
        return $this->belongsToMany(Coupon::class, 'coupons_promo_categories', 'promo_category_id', 'coupon_id');
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
        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'type'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

    /**
     * @Render
     */

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.promo-categories.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.promo-categories.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.promo-categories.restore', $this->id);
    }
}
