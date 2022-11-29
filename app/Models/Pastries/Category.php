<?php

namespace App\Models\Pastries;

use App\Extenders\Models\BaseModel as Model;

class Category extends Model
{
	/*
	 * Relationship
	 */
	
	public function pastries() {
		return $this->hasMany(Pastry::class);
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
    public static function store($request, $item = null, $columns = ['name', 'description'])
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
        return route($prefix . '.categories.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.categories.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.categories.restore', $this->id);
    }
}
