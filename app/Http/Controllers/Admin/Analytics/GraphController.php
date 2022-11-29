<?php

namespace App\Http\Controllers\Admin\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Branches\Branch;
use App\Models\Carts\CartItem;
use App\Models\Invoices\InvoiceItem;
use App\Models\Invoices\Invoice;

use Carbon\Carbon;


class GraphController extends Controller
{
    public function fetchSales(Request $request) {

      $invoices = Invoice::where('is_paid', true)->get();

      if($request->start_date && $request->end_date) {
        $from = Carbon::parse($request->start_date);
        $to = Carbon::parse($request->end_date);

        $invoices = Invoice::groupBy('created_at')->where('is_paid', true)->whereBetween('created_at', [$from, $to])->get();
      }


      if($request->branch_ids) {
        $invoices = Invoice::where('is_paid', true)->whereIn('branch_id', $request->branch_ids)->get();
      }

      $new_series = [];

      foreach ($invoices as $invoice) {
          $new_series[] = Invoice::where('is_paid', true)->where('created_at', $invoice->created_at)->sum('total_payment');
        }
        
        $labels = $invoices->pluck('formatted_created_at');
        $series[] = $new_series;
        
        return response()->json([
          'labels' => $labels,
          'series' => $series,
        ]);
    }
}
