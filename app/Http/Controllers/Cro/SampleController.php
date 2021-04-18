<?php

namespace App\Http\Controllers\Cro;

use App\Models\ReferralSample;
use App\Models\RequestSample;
use App\Models\Request as LabRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Cro\SampleResource;

class SampleController extends Controller
{
    public function index($id)
    {   
        $req = LabRequest::select('type_id')->where('id',$id)->first();

        if($req->type_id == config('app.referral_id')){
            $data = ReferralSample::where('request_id',$id)->get();
        }else{
            $data = RequestSample::where('request_id',$id)->get();
        }
        return SampleResource::collection($data);
    }
    
    public function store(Request $request)
    {
        $id = $request->input('request');
        $req = LabRequest::findOrFail($id);
        
        if($req->type_id == config('app.referral_id')){
            $data = $request->input('edit') ? ReferralSample::findOrFail($request->input('id')) : new ReferralSample;
        }else{
            $data = $request->input('edit') ? RequestSample::findOrFail($request->input('id')) : new RequestSample;
        }

        $data->name = ucwords(strtolower($request->input('name')));
        $data->description = $request->input('desc');
        $data->customer_description = $request->input('customer_desc');
        $data->sampletype_id = $request->input('sampletype');
        $data->laboratory_id = $req->laboratory_id;
        $data->request_id = $request->input('request');
        $data->save();
          
        return new DefaultResource($data);   
    }

    public function destroy(Request $request)
    {
        $data = RequestSample::findOrFail($request->input('id'));
        
        if($data->code == 'n/a'){
            if($data->delete()){
                return new DefaultResource($data);    
            }
        } 
    }
    
}
