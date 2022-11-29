<?php

namespace App\Models\Types;

use App\Extenders\Models\BaseModel as Model;

use App\Traits\ImageTrait;
use App\Traits\DateTrait;

class BookingType extends Model
{
    protected $guarded = [];
    protected $appends = ['img_src'];

    use ImageTrait, DateTrait;


    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'expected_duration', 'description', 'rate', 'additional_fee'])
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

    /*
     * Renderers
     */
    
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.types.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.types.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.types.restore', $this->id);
    }

    /*
     * Append Data
     */
    
    public function getImgSrcAttribute() {
        return $this->renderImagePath();
    }
}
