<?php

namespace App\Http\Controllers\Admin\Types;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Types\BookingTypeStoreRequest;

use App\Models\Types\BookingType;

use DB;

class BookingTypeController extends Controller
{
    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Types\BookingTypeMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Types\BookingTypeIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Types\BookingTypeUpdateMiddleware', ['only' => ['show', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingTypeStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = BookingType::find($id);
        return view('admin.types.show', [
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
    public function update(BookingTypeStoreRequest $request, $id)
    {
        $item = BookingType::find($id);
        $message = "You have successfully updated $item->name ";

        DB::beginTransaction();
            $item = BookingType::store($request, $item);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pastries\BookingType  $item
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = BookingType::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived $item->name",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Pastries\BookingType  $item
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = BookingType::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored $item->name",
        ]);
    }
}
