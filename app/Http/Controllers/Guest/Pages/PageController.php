<?php

namespace App\Http\Controllers\Guest\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Controllers\PageTrait;

use App\Models\Branches\Branch;
use App\Models\Types\BookingType;
use App\Models\Intervals\BlockDateInterval;
use App\Models\Invoices\InvoiceItem;
use App\Models\Promos\Promo;
use App\Models\Pages\PageItem;
use App\Models\Hows\How;

use Carbon\Carbon;

class PageController extends Controller
{
	use PageTrait;

	/* Show Home */
	public function showHome() {

		$promos = Promo::where('is_active', true)->get();
		$branches = Branch::all();
		$hows = How::all();

        return $this->view('guest.pages.home', 'home', [
        	'promos' =>  $promos,
        	'branches' => $branches,
        	'hows' => How::formatlist($hows),
        ]);

	}

	/* Show About */
	public function showAbout() {

        return $this->view('guest.pages.about', 'about', [
        	//
        ]);

	}

	/* Show Terms and Conditions */
	public function showTerms() {

        return $this->view('guest.pages.terms', 'terms_and_conditions', [
        	//
        ]);

	}

	/* Show Privacy Policy */
	public function showPrivacy() {

        return $this->view('guest.pages.privacy', 'privacy_policy', [
        	//
        ]);

	}

	public function showBooking() {
		$branches = Branch::all();
		$types = BookingType::all();
		$blocks = BlockDateInterval::pluck('date');
		$terms_condition = PageItem::where('slug', 'checkout_terms_and_condition')->first() ? PageItem::where('slug', 'checkout_terms_and_condition')->first()->content : null;
		$block_array = [];
		foreach ($blocks as $block) {
			array_push($block_array, [
				str_replace('-','', $block)
			]);
		}
		
		return view('guest.pages.booking', [
			'branches' => $branches,
			'types' => $types,
			'blocks' => json_encode($block_array),
			'terms_condition' => $terms_condition
		]);
	}

	public function branchBlockDate(Request $request) {
		$branch = Branch::find($request->branch_id);

		$blocks = $branch->blockDateIntervals()->whereNull('deleted_at')->get();
		$array = [];
		foreach ($blocks as $block) {
			array_push($array, [
				'is_whole_day' => $block->is_whole_day ? true : false,
				'date' => Carbon::parse($block->date)->subDays(1)->format('Y-m-d'),
				'true_date' => $block->date,
				'formatted_start_time' => $block->start_time ? Carbon::parse($block->start_time)->format('H:i A') : null,
				'start_time' => $block->start_time,
				'formatted_end_time' => $block->end_time ? Carbon::parse($block->end_time)->format('H:i A') : null,
				'end_time' => $block->end_time
			]);
		}

		return response()->json([
			'blocklists' => $array
		]);
	}
}
