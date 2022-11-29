<?php

namespace App\Models\Intervals;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Branches\Branch;

use App\Traits\HelperTrait;

use Carbon\Carbon;

class BlockDateInterval extends Model
{

    use HelperTrait;

    const WHOLEDAY = 1;
    const NOTWHOLEDAY = 0;

    /*
	 * Relationship
	 */
	
	public function branches() {
		return $this->belongsToMany(Branch::class, 'branches_block_date_intervals', 'block_date_id', 'branch_id')->withTrashed();
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
            'date' => $this->date
        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'date', 'start_time', 'end_time'])
    {
        $vars = $request->only($columns);
        $vars['is_whole_day'] = $request->is_whole_day ? 1 : 0;

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

     /*
     * Getters
     */
    
    public static function getWholeDay() {
        return [
            ['value' => static::WHOLEDAY, 'label' => '&#10003;', 'class' => 'bg-primary'],
            ['value' => static::NOTWHOLEDAY, 'label' => '&#10006;', 'class' => 'bg-secondary'],
        ];
    }

    /**
     * @Render
     */
    
    public function renderWholeDayLabel() {
        return $this->renderConstants(static::getWholeDay(), $this->is_whole_day, 'label');
    }

    public function renderWholeDayClass() {
        return $this->renderConstants(static::getWholeDay(), $this->is_whole_day, 'class');
    }

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.intervals.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.intervals.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.intervals.restore', $this->id);
    }

    public function renderStartAndEndTime() {
        $start = Carbon::parse($this->start_time)->format('g:i A');
        $end = Carbon::parse($this->end_time)->format('g:i A');
        $result = $start .' to '. $end;
        return $result;
    }
}
