<?php

namespace App\Http\Controllers\Admin\Hows;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Hows\HowStoreRequest;

use App\Services\PushService;

use App\Models\Hows\How;
use DB;

class HowController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.hows.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HowStoreRequest $request)
    {
        $item = How::store($request);

        $message = "You have successfully created {$item->renderName()}";
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
        $item = How::withTrashed()->findOrFail($id);
        return view('admin.hows.show', [
            'item' => $item,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\How $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function update(HowStoreRequest $request, $id)
    {
        $item = How::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = How::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\How  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = How::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\How  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = How::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

    public function removeImage(Request $request, $id)
    {
        $item = How::withTrashed()->findOrFail($id);
        $message = "You have successfully remove the image in {$item->renderName()}";

        $result = $item->removeImage($request);

        return response()->json([
            'message' => $message,
        ]);
    }
}

