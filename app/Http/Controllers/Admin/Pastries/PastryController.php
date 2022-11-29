<?php

namespace App\Http\Controllers\Admin\Pastries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Pastries\PastryStoreRequest;

use App\Models\Pastries\Pastry;

use DB;

class PastryController extends Controller
{
    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Pastries\PastryMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Pastries\PastryIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Pastries\PastryStoreMiddleware', ['only' => ['create', 'store']]);
        $this->middleware('App\Http\Middleware\Admin\Pastries\PastryUpdateMiddleware', ['only' => ['show', 'update']]);
        $this->middleware('App\Http\Middleware\Admin\Pastries\PastryDestroyMiddleware', ['only' => ['archive', 'restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pastries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pastries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PastryStoreRequest $request)
    {
        DB::beginTransaction();
            $item = Pastry::store($request);
        DB::commit();
        $message = "You have successfully created $item->name";
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
        $item = Pastry::withTrashed()->findOrFail($id);
        return view('admin.pastries.show', [
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
    public function update(PastryStoreRequest $request, $id)
    {
        $item = Pastry::withTrashed()->findOrFail($id);
        $message = "You have successfully updated $item->name";

        DB::beginTransaction();
            $item = Pastry::store($request, $item);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pastries\Pastry  $item
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Pastry::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived $item->name",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Pastries\Pastry  $item
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Pastry::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored $item->name",
        ]);
    }
}
