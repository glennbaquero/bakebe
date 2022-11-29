<?php
namespace App\Http\Controllers\Admin\Pastries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Pastries\Category;

use App\Http\Requests\Admin\Pastries\CategoryStoreRequest;

class CategoryController extends Controller
{

    public function __construct() {
        // $this->middleware('App\Http\Middleware\Admin\Pastries\CategoryMiddleware', 
        //     ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        // );
        $this->middleware('App\Http\Middleware\Admin\Pastries\CategoryIndexMiddleware', ['only' => ['index']]);
        $this->middleware('App\Http\Middleware\Admin\Pastries\CategoryStoreMiddleware', ['only' => ['create', 'store']]);
        $this->middleware('App\Http\Middleware\Admin\Pastries\CategoryUpdateMiddleware', ['only' => ['show', 'update']]);
        $this->middleware('App\Http\Middleware\Admin\Pastries\CategoryDestroyMiddleware', ['only' => ['archive', 'restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $item = Category::store($request);

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
        $item = Category::withTrashed()->findOrFail($id);
        return view('admin.categories.show', [
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
    public function update(CategoryStoreRequest $request, $id)
    {
        $item = Category::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = Category::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destination  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Category::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Destination  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Category::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

}
