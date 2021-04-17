<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function staffs()
    {
        return view('user_admin.staff');
    }

    public function agencies()
    {
        return view('user_admin.agency');
    }

    public function dropdownlists()
    {
        return view('user_admin.dropdownlist');
    }

    public function testservices()
    {
        return view('user_admin.testservice');
    }

    public function packages()
    {
        return view('user_admin.package');
    }

    public function addons()
    {
        return view('user_admin.addon');
    }
}
