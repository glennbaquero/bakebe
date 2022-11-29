<?php

namespace App\Http\Controllers\Admin\Pastries;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Pastries\Pastry;
use App\Models\Pastries\Category;

class PastryFetchController extends Controller
{
	/**
	 * Set object class of fetched data
	 * 
	 * @return void
	 */
	public function setObjectClass()
	{
	    $this->class = new Pastry;
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
	            'category' => $item->category->name,
	            'difficulty' => $item->difficulty,
	            'duration' => $item->convertToHoursMins($item->duration),
	            'express_duration' => $item->convertToHoursMins($item->express_duration),
                'active_label' => $item->renderActiveLabel(),
                'active_class' => $item->renderActiveClass(),
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
	    $categories = Category::all();

	    if ($id) {
	        $item = Pastry::withTrashed()->findOrFail($id);
	        // $item->is_available_express = $item->is_available_express ? true : false;
	        // $item->is_available_regular = $item->is_available_regular ? true : false;
	        $item->is_active = $item->is_active ? true : false;
	        $item = $this->formatView($item);
	    }

	    return response()->json([
	        'item' => $item,
	        'categories' => $categories,
	    ]);
	}

	protected function formatView($item)
	{
	    $item->archiveUrl = $item->renderArchiveUrl();
	    $item->restoreUrl = $item->renderRestoreUrl();
        $item->path = $item->renderImagePath();

	    return $item;
	}
}
