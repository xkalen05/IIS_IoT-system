<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $systems = DB::table('systems')->paginate(10);

        return view('admin.systems.index')->with(['systems' => $systems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        System::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        //TODO

        return redirect(route('admin.systems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        DB::table('systems')->where('id', '=', $request->input('system_id'))->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

        return redirect(route('admin.systems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('systems')->where('id', '=', $id)->delete();
        return redirect(route('admin.systems'));
    }
}
