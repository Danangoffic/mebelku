<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
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
                $query = User::query();
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        return '
                            <a title="Edit ' . $item->name . '" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" href="' . route('dashboard.user.edit', $item->id) . '">Edit</a>
                            <form class="inline-block" action="' . route('dashboard.user.destroy', $item->id) . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                                <button title="Delete ' . $item->name . '" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" type="submit">Delete</button>
                            </form>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
                Log::error("error with : " . $th->getMessage() . " code " . $th->getCode());
            }
        }
        return view('pages.dashboard.user.index');
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
    public function edit(User $user)
    {
        return view('pages.dashboard.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();

        $user->update($data);
        return redirect()->route('dashboard.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard.user.index');
    }
}
