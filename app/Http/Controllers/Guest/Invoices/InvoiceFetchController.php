<?php

namespace App\Http\Controllers\Guest\Invoices;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Invoices\Invoice;
use App\Models\Branches\Branch;

use Carbon\Carbon;

class InvoiceFetchController extends Controller
{
    /**
	 * Set object class of fetched data
	 * 
	 * @return void
	 */
	public function setObjectClass()
	{
	    $this->class = new Invoice;
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

	    return $query->where('is_paid', true);
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
	    	foreach ($item->invoiceItems as $invoiceItem) {
	    		$working_start = Carbon::parse($invoiceItem->branch->work_start)->format('H:i a');
	    		$working_end = Carbon::parse($invoiceItem->branch->work_end)->format('H:i a');
	    		$added_time = Carbon::parse($invoiceItem->branch->work_start)->addHours(30);
	    		
	    		// if(!$this->in_multiarray($invoiceItem->scheduled_date, $result, 'schedule_date') && !$this->in_multiarray($invoiceItem->branch_id, $result, 'branch_id')) {
	    		// 	array_push($result, [
	    		// 	    'id' => $invoiceItem->id,
	    		// 	    'branch_id' => $invoiceItem->branch_id,
	    		// 	    'schedule_date' => $invoiceItem->scheduled_date,
	    		// 	    'attendees' => $invoiceItem->branch->invoiceItems()->sum('attendees'),
	    		// 	]);
	    		// }
	    		
	    	}
	    }

	    return $result;
	}

	public function in_multiarray($elem, $array,$field)
	{
	    $top = sizeof($array) - 1;
	    $bottom = 0;
	    while($bottom <= $top)
	    {
	        if($array[$bottom][$field] == $elem)
	            return true;
	        else 
	            if(is_array($array[$bottom][$field]))
	                if($this->in_multiarray($elem, ($array[$bottom][$field])))
	                    return true;

	        $bottom++;
	    }        
	    return false;
	}
}
