<?php

namespace App\Http\Controllers\Admin\Reservations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Arr;

use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Admin\Reservations\InvoiceFetchController;

use App\Exports\Invoices\InvoiceExport;

use App\Models\Invoices\Invoice;
use App\Models\Invoices\InvoiceItem;
use App\Models\Branches\Branch;

use Excel;
use DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Reservations\ReservationMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Reservations\ReservationIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Reservations\ReservationExportMiddleware', ['only' => ['export']]);
        $this->middleware('App\Http\Middleware\Admin\Reservations\ReservationUpdateMiddleware', ['only' => ['show', 'update']]);
        $this->middleware('App\Http\Middleware\Admin\Reservations\ReservationMarkAsClaimedInvoiceItemMiddleware', ['only' => ['markAsClaimed']]);
        $this->middleware('App\Http\Middleware\Admin\Reservations\ReservationMarkAsClaimedInvoiceMiddleware', ['only' => ['invoiceMarkAsClaimed']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_status = Invoice::getPaymentStatus();
        $payment_types = Invoice::getPaymentType();
        $branches = Branch::all();
        return view('admin.reservations.index', [
            'payment_types' => json_encode($payment_types),
            'payment_status' => json_encode($payment_status),
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reservations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // DB::beginTransaction();
        //     $item = Invoice::store($request);
        // DB::commit();
        // $message = "You have successfully created `{$item->reference_number}`";
        // $redirect = $item->renderShowUrl();

        // return response()->json([
        //     'message' => $message,
        //     'redirect' => $redirect,
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Invoice::find($id);
        return view('admin.reservations.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Invoice::find($id);
        $message = "You have successfully updated `{$item->reference_number}`";

        DB::beginTransaction();
            $item = Invoice::store($request, $item);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    }

    public function export(Request $request)
    {
        $controller = new InvoiceFetchController;

        $request = $request->merge(['nopagination' => 1]);

        $data = [];
        $data = $controller->fetch($request);

        $message = 'Exporting data, please wait...';

        if (!$data) {
            throw ValidationException::withMessages([
                'items' => 'No reservation found.',
            ]);
        }


        if (!$request->ajax()) {
            $ids = Arr::pluck($data->original['items'], 'id');
            return Excel::download(new InvoiceExport($data->original['items']), 'reservation_from-' . $request->start_date.'_to-'.$request->end_date . '.xlsx');
        }
    }

    public function markAsClaimed($id) {
        $item = InvoiceItem::find($id);

        $message = "You have successfully claimed `{$item->invoice->reference_number}`";

        DB::beginTransaction();
            $item->update(['is_claim' => true]);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    } 

    public function invoiceMarkAsClaimed($id) {
        $item = Invoice::find($id);

        $message = "You have successfully claimed `{$item->reference_number}`";

        DB::beginTransaction();
            $item->update(['is_claim' => true]);
            $item->invoiceItems()->update(['is_claim' => true]);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    } 
}
