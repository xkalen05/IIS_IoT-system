<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class RequestsController extends Controller
{
    public function acceptShareRequest(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Application
    {
        $validator = Validator::make($request->all(), [
            'system_id' => 'required',
            'user_id' => 'required',
            'request_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $system = System::find($request->input('system_id'));
        $system->users()->attach($request->input('user_id'));
        $requestID = $request->input('request_id');

        try {
            DB::table('system_sharing_requests')
                ->where('id', '=', $requestID)
                ->delete();
        }catch (Exception $e){
            return redirect(route('admin.systems'))->with('error', 'Sharing request could not be resolved. Request was already resolved or does not exist');
        }

        return redirect(route('admin.systems'))->with('success', 'Sharing request was accepted');
    }

    public function denyShareRequest(string $requestID)
    {
        try {
            DB::table('system_sharing_requests')
                ->where('id', '=', $requestID)
                ->delete();
        }catch (Exception $e){
            return redirect(route('admin.systems'))->with('error', 'Sharing request could not be resolved. Request was already resolved or does not exist');
        }
        return redirect(route('admin.systems'))->with('success', 'Sharing request was denied');
    }
}
