<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
    public function acceptShareRequest(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Application
    {
        $system = System::find($request->input('system_id'));
        $system->users()->attach($request->input('user_id'));
        $requestID = $request->input('request_id');

        DB::table('system_sharing_requests')->where('id', '=', $requestID)->delete();

        return redirect(route('admin.systems'));
    }

    public function denyShareRequest(string $requestID)
    {
        DB::table('system_sharing_requests')->where('id', '=', $requestID)->delete();
        return redirect(route('admin.systems'));
    }
}
