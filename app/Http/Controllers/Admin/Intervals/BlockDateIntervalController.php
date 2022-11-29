<?php

namespace App\Http\Controllers\Admin\Intervals;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Intervals\BlockDateIntervalStoreRequest;

use App\Models\Intervals\BlockDateInterval;

use DB;

class BlockDateIntervalController extends Controller
{
    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Intervals\BlockDateIntervalMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Intervals\BlockDateIntervalIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Intervals\BlockDateIntervalStoreMiddleware', ['only' => ['create', 'store']]);
        $this->middleware('App\Http\Middleware\Admin\Intervals\BlockDateIntervalUpdateMiddleware', ['only' => ['show', 'update']]);
        $this->middleware('App\Http\Middleware\Admin\Intervals\BlockDateIntervalDestroyMiddleware', ['only' => ['archive', 'restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.intervals.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.intervals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockDateIntervalStoreRequest $request)
    {
        DB::beginTransaction();
            $item = BlockDateInterval::store($request);
            $item->branches()->sync($request->branches_id);
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
        $item = BlockDateInterval::withTrashed()->findOrFail($id);
        return view('admin.intervals.show', [
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
    public function update(BlockDateIntervalStoreRequest $request, $id)
    {
        $item = BlockDateInterval::withTrashed()->findOrFail($id);
        $message = "You have successfully updated $item->name";

        DB::beginTransaction();
            $item = BlockDateInterval::store($request, $item);
            $item->branches()->sync($request->branches_id);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pastries\BlockDateInterval  $item
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = BlockDateInterval::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived $item->name",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Pastries\BlockDateInterval  $item
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = BlockDateInterval::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored $item->name",
        ]);
    }
}
