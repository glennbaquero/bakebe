<?php

namespace App\Http\Controllers\Admin\Intervals;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Intervals\BlockDateInterval;
use App\Models\Branches\Branch;

use Carbon\Carbon;

class BlockDateIntervalFetchController extends Controller
{
    /**
	 * Set object class of fetched data
	 * 
	 * @return void
	 */
	public function setObjectClass()
	{
	    $this->class = new BlockDateInterval;
	}

	/**
	 * Custom filtering of query
	 * 
	 * @param Illuminate\Support\Facades\DB $query
	 * @return Illuminate\Support\Facades\DB $query
	 */
	public function filterQuery($query)
	{
	    /**
	     * Queries
	     * 
	     */

	    return $query;
	}

	/**
	 * Custom formatting of data
	 * 
	 * @param Illuminate\Support\Collection $items
	 * @return array $result
	 */
	public function formatData($items)
	{
	    $result = [];

	    foreach($items as $item) {
	        $data = $this->formatItem($item);
	        $data = array_merge($data, [
	            'id' => $item->id,
	            'name' => $item->name,
	            'date' => Carbon::parse($item->date)->format('M. d, Y'),
	            'time' => $item->is_whole_day ? 'Whole day' : $item->renderStartAndEndTime(),
                'whole_day_label' => $item->renderWholeDayLabel(),
                'whole_day_class' => $item->renderWholeDayClass(),
	            'created_at' => $item->renderDate(),
	            'deleted_at' => $item->deleted_at,
	        ]);

	        array_push($result, $data);
	    }

	    return $result;
	}

	/**
	 * Build array data
	 * 
	 * @param  App\Contracts\AvailablePosition
	 * @return array
	 */
	protected function formatItem($item)
	{
	    return [
	        'showUrl' => $item->renderShowUrl(),
	        'archiveUrl' => $item->renderArchiveUrl(),
	        'restoreUrl' => $item->renderRestoreUrl(),
	    ];
	}

	public function fetchView($id = null)
	{
	    $item = null;
	    $branches = Branch::all();

	    if ($id) {
	        $item = BlockDateInterval::withTrashed()->findOrFail($id);
	        $item->branch_ids = $item->branches()->pluck('id')->toArray();
	        $item = $this->formatView($item);
	    }

	    return response()->json([
	        'item' => $item,
	        'branches' => $branches,
	    ]);
	}

	protected function formatView($item)
	{
	    $item->archiveUrl = $item->renderArchiveUrl();
	    $item->restoreUrl = $item->renderRestoreUrl();

	    return $item;
	}
}
