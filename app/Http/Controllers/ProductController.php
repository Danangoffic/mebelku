<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            try {
                $query = Product::query();
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        return '
                            <a title="Gallery ' . $item->name . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" href="' . route('dashboard.product.gallery.index', $item->id) . '">Gallery</a>
                            <a title="Edit ' . $item->name . '" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" href="' . route('dashboard.product.edit', $item->id) . '">Edit</a>
                            <form class="inline-block" action="' . route('dashboard.product.destroy', $item->id) . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                                <button title="Delete ' . $item->name . '" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" type="submit">Delete</button>
                            </form>
                        ';
                    })
                    ->editColumn('price', function ($item) {
                        return 'Rp ' . number_format($item->price, 0, ',', '.');
                    })
                    ->rawColumns(['action'])
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
                Log::error("error with : " . $th->getMessage() . " code " . $th->getCode());
            }
        }
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name); //use Illuminate\Support\Str;
        $data['name'] = Str::title($request->name);

        Product::create($data);
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name); //use Illuminate\Support\Str;
        $data['name'] = Str::title($request->name);

        $product->update($data);
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.product.index');
    }
}
