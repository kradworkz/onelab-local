<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function orseries(){
        return view('user_finance.orseries');
    }

    public function orderofpayments(){
        return view('user_finance.orderofpayment');
    }

    public function orderofpayment(){
        return view('user_finance.orderofpaymentview');
    }

    public function types(){
        return view('user_finance.type');
    }
}
