<?php

namespace App\Http\Controllers\Web\Bookings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Invoices\Invoice;
use App\Models\Invoices\InvoiceItem;

use DB;
use Auth;
use Storage;

class BookingController extends Controller
{

    public function showInvoice($id)
    {
        $item = Invoice::where("reference_number", $id)->firstOrFail();
        return view('web/pages/booking-history', [
            'item' => $item,

        ]);
    }
	
    /**
     * Export invoice to PDF
     * 
     * @param  int $id
     */
    public function printInvoice($id)
    {

        $item = Invoice::where("reference_number", $id)->firstOrFail();
        $logo = Storage::url('images/assets/logo.png');

        return view('web/pages/invoice', [
            'item' => $item,

        ]);

    }    

}

?>