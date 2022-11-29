<?php

namespace App\Http\Controllers\Guest\Pastries;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Pastries\Pastry;

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

	    $query = $query->where('is_active', true);

	    if($this->request->filled('type')) {
	    	if($this->request->type === 'express') {
			    $query = $query->where('is_available_express', true);
	    	} elseif ($this->request->type === 'regular') {
			    $query = $query->where('is_available_regular', true);
	    	}
	    }
	    
	    if($this->request->filled('difficulty') && $this->request->difficulty != 0) {
		    $query = $query->where('difficulty', $this->request->difficulty);
	    }

	    if($this->request->filled('duration') && $this->request->duration != 0) {
		    $query = $query->where('duration', $this->request->duration);
	    }

	    if($this->request->filled('category_id') && $this->request->category_id != 0) {
		    $query = $query->where('category_id', $this->request->category_id);
	    }

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
	        array_push($result, [
	            'id' => $item->id,
	            'name' => $item->name,
	            'category' => $item->category->name,
	            'category_id' => $item->category->id,
	            'difficulty' => $item->difficulty,
	            'description' => $item->description,
	            'duration_label' => $item->convertToHoursMins($item->duration),
	            'duration' => $item->duration,
	            'express_duration' => $item->express_duration,
	            'express_duration' => $item->convertToHoursMins($item->express_duration),
	            'express_amount' => $item->express_amount,
	            'regular_amount' => $item->regular_amount,
	            'additional_express_amount' => $item->additional_express_amount,
	            'additional_regular_amount' => $item->additional_regular_amount,
	            'image_path' => $item->renderImagePath(),
	            'created_at' => $item->renderDate(),
	        ]);
	    }

	    return $result;
	}
}
