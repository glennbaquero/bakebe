<?php

namespace App\Http\Controllers\Admin\Coupons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Coupons\CouponStoreRequest;

use App\Models\Coupons\Coupon;

class CouponController extends Controller
{
    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Coupons\CouponMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Coupons\CouponIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Coupons\CouponStoreMiddleware', ['only' => ['create', 'store']]);
        $this->middleware('App\Http\Middleware\Admin\Coupons\CouponUpdateMiddleware', ['only' => ['show', 'update']]);
        $this->middleware('App\Http\Middleware\Admin\Coupons\CouponDestroyMiddleware', ['only' => ['archive', 'restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request)
    {
        $item = Coupon::store($request);

        $message = "You have successfully created Code ID : {$item->code}";
        $redirect = $item->renderShowUrl();

        return response()->json([
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Coupon::withTrashed()->findOrFail($id);
        return view('admin.coupons.show', [
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
        $item = Coupon::withTrashed()->findOrFail($id);
        return view('admin.coupons.show', [
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
    public function update(CouponStoreRequest $request, $id)
    {
        $item = Coupon::withTrashed()->findOrFail($id);
        $message = "You have successfully updated Code ID : {$item->code}";

        $item = Coupon::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupons\Coupon  $item
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Coupon::withTrashed()->findOrFail($id);
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
        $item = Coupon::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored Code ID : {$item->code}",
        ]);
    }
}
