<?php

namespace App\Http\Controllers\Admin\Promos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Promos\PromoStoreRequest;

use App\Models\Promos\Promo;

use DB;

class PromoController extends Controller
{
    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Promos\PromoMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Promos\PromoIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Promos\PromoStoreMiddleware', ['only' => ['create', 'store']]);
        $this->middleware('App\Http\Middleware\Admin\Promos\PromoUpdateMiddleware', ['only' => ['show', 'update']]);
        $this->middleware('App\Http\Middleware\Admin\Promos\PromoDestroyMiddleware', ['only' => ['archive', 'restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.promos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromoStoreRequest $request)
    {
        DB::beginTransaction();
            $item = Promo::store($request);
        DB::commit();

        $message = "You have successfully created $item->name ";
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
        $item = Promo::withTrashed()->findOrFail($id);
        return view('admin.promos.show', [
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
    public function update(PromoStoreRequest $request, $id)
    {
        $item = Promo::withTrashed()->findOrFail($id);
        $message = "You have successfully updated $item->name ";

        DB::beginTransaction();
            $item = Promo::store($request, $item);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promos\Promo  $item
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Promo::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived $item->name ",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Promos\Promo  $item
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Promo::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored $item->name ",
        ]);
    }
}
