<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KPIController extends Controller
{
    public function index()
    {
        $kpi = DB::table('kpi')->paginate(10);

        $types = DB::table('types')->get();

        return view('admin.kpi.index', compact('types', 'types'))->with(['kpi' => $kpi]);

    }

    public function create(Request $request)
    {
        DB::table('kpi')->insert([
            'type_id' => $request->input('type'),
            'user_id' => Auth::user()['id'],
            'name' => $request->input('name'),
        ]);

        return redirect()->back();
    }

    public function destroy(string $id){

        DB::table('kpi')->where('id','=',$id)->delete();

        return redirect()->back();
    }
}
