<?php

namespace App\Http\Controllers\Cro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function customers(){
        return view('user_cro.customer');
    }

    public function requests(){
        return view('user_cro.request');
    }

    public function request(){
        return view('user_cro.requestview');
    }

    public function reports(){
        return view('user_cro.report');
    }
}
