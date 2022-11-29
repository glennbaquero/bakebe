<?php

namespace App\Http\Controllers\Guest\Timeslots;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Branches\Branch;
use App\Models\Pastries\Pastry;
use App\Models\Invoices\InvoiceItem;

use Carbon\Carbon;

class TimeslotController extends Controller
{
	/**
	 *
	 * @return  array $list
	 */
    public function getTimeSlot(Request $request) {
		$branch = Branch::find($request->branch_id);
		$list = [];

		$duration = $request->duration;
		$end = $branch->work_end;
		$parts = explode(':', $end);
		$end = (($parts[0] * 60) + $parts[1]) - $duration;
		$hours = floor($end / 60);
		$minutes = $end % 60;
		$work_end = sprintf('%02d:%02d:00', $hours, $minutes);
		// dd($end, $branch->work_end, $work_end);
		$start = Carbon::parse($branch->work_start)->format('H');
		$end = Carbon::parse($work_end)->format('H') === '00' ? 24 : Carbon::parse($work_end)->format('H');


		$dateAndTime = $request->date.' '.$branch->work_start;
		$date = Carbon::parse($dateAndTime);
		$conditional_date = Carbon::parse($dateAndTime);


		$working_hours = $end - $start;
		$working_hours *= 2;
		$interval = 30;
		$today = Carbon::now()->format('Y-m-d');
		$time_now = Carbon::now();

		for($incrmt = 1; $incrmt <= $working_hours; $incrmt++) {
			$value = $date->addDays($incrmt)->addMinute($interval)->format('H:i:s');
			$conditional_value = $conditional_date->addDays($incrmt)->addMinute($interval)->format('H:i:s');
			$slot_attendees = $branch->invoiceItems->where('start_time', $value)->where('scheduled_date', $request->date)->sum('attendees');
			$available = $branch->available_oven - $slot_attendees;

			// if(Carbon::parse($work_end)->format('h:i A') != Carbon::parse($value)->format('h:i A')) {
			if(Carbon::parse($work_end)->gt(Carbon::parse($value)) || Carbon::parse($work_end)->format('h:i A') == Carbon::parse($value)->format('h:i A')) {
				if($today === $request->date) {
					if(Carbon::parse($conditional_value)->gt($time_now)) {
						array_push($list, [
							'slots_available' => $available, 
							'show' => $available > 0 ? true : false,
							'value' =>  $value,
			                'label' => Carbon::parse($value)->format('h:i A'),
						]);
					}
				} else {
					array_push($list, [
						'slots_available' => $available, 
						'show' => $available > 0 ? true : false,
						'value' =>  $value,
		                'label' => Carbon::parse($value)->format('h:i A'),
					]);
				}
			}
			
		}

		return response()->json([
			'list' => $list,
		]);
	}

	/**
	 * Get all the dates with fully booked reservation
	 *
	 * @return  array $dates
	 */
	public function getFullyBookedDates(Request $request) {
		$lists = [];
		
		$branch = Branch::find($request->branch_id);
		$end = Carbon::parse($branch->work_end)->format('H') === '00' ? 24 : Carbon::parse($branch->work_end)->format('H');
		$start = Carbon::parse($branch->work_start)->format('H');

		$working_hours = $end - $start;
		$working_hours *= 2;
		
		$total_oven = $branch->available_oven * ($working_hours);
		// $end = Carbon::parse($branch->work_end)->format('H');
		$duration = floor($request->duration / 60);
		
		// $duration = floor($request->duration / 60);
		$now = now()->subDays(1);

		// foreach ($branch->invoiceItems as $item) {
			for ($i=1; $i <= 365 ; $i++) { 
				$dateAndTime = Carbon::parse($now)->addDays($i)->format('Y-m-d').' '.$branch->work_start;
				$date_formatted = Carbon::parse($dateAndTime)->format('F d-Y');
				$date = Carbon::parse($dateAndTime)->format('Y-m-d');

				$get_reservation = $branch->invoiceItems->where('scheduled_date', $date);

				if(!$this->in_multiarray($date, $lists, 'date')) {
					array_push($lists, [
						'formatted_date' => $date_formatted,
						'date' => $date,
						'available_oven' => $total_oven,
						'fullybooked_date' => str_replace('-', '', $date),
						'reservation' => $get_reservation->sum('attendees'),
						'is_available' => $get_reservation->sum('attendees') < $total_oven
					]);
				}
			}
		// }
		

		return response()->json([
			'lists' => $lists,
		]);
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
