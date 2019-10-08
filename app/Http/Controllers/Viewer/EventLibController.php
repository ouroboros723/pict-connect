<?php

namespace App\Http\Controllers\Viewer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventLibController extends Controller
{
    public function index()
    {
        $user_info = \Auth::user();

        return view('viewer.pages.event-lib', ['user_info' => $user_info]);
    }
}
