<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;

class LogActivityController extends Controller
{
    public function index()
    {
        $log = LogActivity::all();

        return view('pages.logActivity.index', ['log' => $log]);
    }
}
