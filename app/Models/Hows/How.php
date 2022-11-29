<?php

namespace App\Models\Hows;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Hows\How;

use App\Traits\ImageTrait;

class How extends Model
{

    use ImageTrait;
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

        if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'types');
        }


        return $item;
    }
    
    public static function formatItem($item) {
        return [
            'name' => $item->name,
            'description' => $item->description,
            'image_path' => $item->renderImagePath('image_path'),
        ];
    }
    
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.hows.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.hows.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.hows.restore', $this->id);
    }
}
