<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexAdmin(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.dashboard');
    }

    public function indexUser(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('basic_user.dashboard');
    }
}
