<?php

namespace App\Http\Controllers\Cro;

use App\Models\User;
use App\Models\Customer;
use App\Models\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Cro\CustomerResource;
use App\Http\Resources\Cro\CustomerAddressResource;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::orderBy('id','DESC')->paginate(10);
        return CustomerResource::collection($data);
    }

    public function lists()
    {
        $data = Customer::orderBy('id','ASC')->get();
        return CustomerResource::collection($data);
    }
    
    public function store(CustomerRequest $request)
    {
        $user = $request->isMethod('put') ? User::findOrFail($request->input('id')) : new User;

        if(!$request->isMethod('put')){
            $user->email = strtolower($request->input('email'));
            $user->type = 'Customer';
            $user->password = bcrypt(123456789);
        }
    
        if($user->save())
        {
            $data = $request->isMethod('put') ? Customer::findOrFail($request->input('id')) : new Customer;
            $data->name = ucwords(strtolower($request->input('name')));
            $data->type_id = $request->input('type');
            $data->bussiness_id = $request->input('bussiness');
            $data->classification_id = $request->input('classification');
            $data->industry_id = $request->input('industry');
            $data->user_id = $user->id;
            
            if($data->save()){
                if($request->isMethod('put'))
                {
                    $address = $data->address()->update([
                        'address' => ucwords($request->input('address')),
                        'region_id' =>$request->input('region'),
                        'province_id' =>$request->input('province'),
                        'municipality_id' =>$request->input('municipality'),
                    ]);
                }else{
                    $address = $data->address()->create([
                        'type' => 'Customer',
                        'address' => ucwords($request->input('address')),
                        'region_id' =>$request->input('region'),
                        'province_id' =>$request->input('province'),
                        'municipality_id' =>$request->input('municipality'),
                    ]);
                }

                if($request->isMethod('put'))
                {
                    $address->contact()->update([
                        'mobile_no' => ucwords($request->input('mobile')),
                        'tel_no' =>($request->input('tel')) ? $request->input('tel') : 'n/a',
                        'fax' =>($request->input('fax')) ? $request->input('fax') : 'n/a',
                    ]);
                }else{
                    $address->contact()->create([
                        'mobile_no' => ucwords($request->input('mobile')),
                        'tel_no' =>($request->input('tel')) ? $request->input('tel') : 'n/a',
                        'fax' =>($request->input('fax')) ? $request->input('fax') : 'n/a',
                    ]);
                }
            }
        }

        return new CustomerResource($data);
    }

    public function storebranch(CustomerRequest $request)
    {
        
            $data = Customer::findOrFail($request->input('id'));
          
            if($request->isMethod('put'))
            {
                $address = $data->address()->update([
                    'address' => ucwords($request->input('address')),
                    'region_id' =>$request->input('region'),
                    'province_id' =>$request->input('province'),
                    'municipality_id' =>$request->input('municipality'),
                ]);
            }else{
                $address = $data->address()->create([
                    'type' => 'Customer',
                    'address' => ucwords($request->input('address')),
                    'region_id' =>$request->input('region'),
                    'province_id' =>$request->input('province'),
                    'municipality_id' =>$request->input('municipality'),
                ]);
            }

            if($request->isMethod('put'))
            {
                $address->contact()->update([
                    'mobile_no' => ucwords($request->input('mobile')),
                    'tel_no' =>($request->input('tel')) ? $request->input('tel') : 'n/a',
                    'fax' =>($request->input('fax')) ? $request->input('fax') : 'n/a',
                ]);
            }else{
                $address->contact()->create([
                    'mobile_no' => ucwords($request->input('mobile')),
                    'tel_no' =>($request->input('tel')) ? $request->input('tel') : 'n/a',
                    'fax' =>($request->input('fax')) ? $request->input('fax') : 'n/a',
                ]);
            }
        return new CustomerResource($data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('word');
        $data = Customer::where('name','!=','Referral')->where('name','like','%'.$keyword.'%')->paginate(5);

        return CustomerResource::collection($data);
    }

    public function searchbranch(Request $request)
    {
        $keyword = $request->input('word');
        $data = Address::where('type','Customer')->paginate(5);

        return CustomerAddressResource::collection($data);
    }
}
