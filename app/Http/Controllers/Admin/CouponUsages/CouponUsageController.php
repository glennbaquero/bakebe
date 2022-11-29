<?php

namespace App\Http\Controllers\Admin\CouponUsages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Coupons\CouponUsageStoreRequest;

use App\Models\Invoices\Invoice;
use App\Models\Coupons\CouponUsage;

class CouponUsageController extends Controller
{
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\CouponUsages\CouponUsageMiddleware', 
            ['only' => ['index', 'show', 'update', 'archive', 'restore']]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.couponusages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponUsageStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($reference_number)
    {
        $item = Invoice::withTrashed()->findOrFail($reference_number);
        return view('admin.reservations.show', [
            'item' => $item,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showInvoice($id)
    {
        $item = Invoice::where("reference_number", $id)->firstOrFail();
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
    public function update(CouponUsageStoreRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupons\Coupon  $item
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = CouponUsage::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived Code ID : {$item->code}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Coupons\Coupon  $item
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = CouponUsage::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored Code ID : {$item->code}",
        ]);
    }
}
