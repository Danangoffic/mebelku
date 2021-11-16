<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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
                $query = Transaction::query();
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        return '
                            <a title="Show" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" href="' . route('dashboard.transaction.show', $item->id) . '">Show</a>
                            <a title="Edit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" href="' . route('dashboard.transaction.edit', $item->id) . '">Edit</a>
                        ';
                    })
                    ->editColumn('total_price', function ($item) {
                        return 'Rp ' . number_format($item->total_price, 0, ',', '.');
                    })
                    ->rawColumns(['action'])
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
                Log::error("error with : " . $th->getMessage() . " code " . $th->getCode());
            }
        }
        return view('pages.dashboard.transaction.index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            try {
                $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);
                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return 'Rp ' . number_format($item->product->price, 0, ',', '.');
                    })
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
                Log::error("error with : " . $th->getMessage() . " code " . $th->getCode());
            }
        }
        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.dashboard.transaction.edit', [
            'item' => $transaction
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $data = $request->all();

        $transaction->update($data);
        return redirect()->route('dashboard.transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
