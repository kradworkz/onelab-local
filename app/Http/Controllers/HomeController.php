<?php

namespace App\Http\Controllers;

use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\DefaultResource;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->status == "Inactive"){
            return view('user_public.password');
        }else if(Auth::user()->type == "Customer Relations Officer"){
            return view('user_cro.index');    
        }else if(Auth::user()->type == "Cashier"){
            return view('user_finance.index');
        }else if(Auth::user()->type == "Lab Analyst"){
            return view('user_analyst.index');
        }else{
            return view('user_admin.index');
        }
    }
    
    public function regions()
    {
        $data = LocationRegion::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function provinces($id)
    {
        $data = LocationProvince::where('region_id',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function municipalities($id)
    {
        $data = LocationMunicipality::where('province_id',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

}
