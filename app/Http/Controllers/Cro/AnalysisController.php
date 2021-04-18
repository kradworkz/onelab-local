<?php

namespace App\Http\Controllers\Cro;

use App\Models\ReferralSample;
use App\Models\RequestSample;
use App\Models\RequestAnalysis;
use App\Models\ReferralAnalysis;
use App\Models\ListPackage;
use App\Models\ListPackageList;
use App\Models\ListTestService;
use App\Models\RequestSamplePackage;
use App\Models\Request as LabRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Cro\AnalysesResource;
use App\Http\Resources\Cro\AnalysisResource;
use App\Http\Resources\Cro\PackageResource;
use App\Http\Resources\Cro\PackResource;

class AnalysisController extends Controller
{
    public function index($id)
    {   
        $req = LabRequest::findOrFail($id);
        ($req->type_id == config('app.local_id')) ? $ids = RequestSample::where('request_id',$id)->pluck('id') : $ids = ReferralSample::where('request_id',$id)->pluck('id');
        ($req->type_id == config('app.local_id')) ? $data = RequestAnalysis::where('is_package',1)->whereIn('sample_id',$ids)->get() : $data = ReferralAnalysis::where('is_package',1)->whereIn('sample_id',$ids)->get();
      
        return AnalysesResource::collection($data);
    }

    public function package($id)
    {
        $ids = RequestSample::where('request_id',$id)->pluck('id');
        $data = RequestSamplePackage::whereIn('sample_id',$ids)->get();
      
        return PackResource::collection($data);
    }
    
    public function store(Request $request)
    {   
        if($request->input('type') == 'Solo'){
            $data = ListTestService::find($request->input('method_id'));

            if($request->input('requesttype') != 'Referral'){
                $analysis = $data->analysis()->create([
                    'fee' => $request->input('fee'),
                    'sample_id' => $request->input('sample_id')
                ]);
            }else{
                $analysis = $data->referralanalysis()->create([
                    'fee' => $request->input('fee'),
                    'sample_id' => $request->input('sample_id')
                ]);
            }
            
            return new DefaultResource($data);
        }else{

            $lists = ListPackageList::where('package_id',$request->input('method_id'))->pluck('testservice_id');
            
            foreach($lists as $list)
            {
                $data = ListTestService::find($list);

                if($request->input('requesttype') != 'Referral'){
                    $analysis = $data->analysis()->create([
                        'fee' => 0,
                        'sample_id' => $request->input('sample_id'),
                        'package_id' => $request->input('method_id'),
                        'is_package' => 0
                    ]);
                }else{
                    $analysis = $data->referralanalysis()->create([
                        'fee' => 0,
                        'sample_id' => $request->input('sample_id'),
                        'package_id' => $request->input('method_id'),
                        'is_package' => 0
                    ]);
                }
            }

            $pack = ListPackage::where('id',$request->input('method_id'))->first();
            ($request->input('requesttype') != 'Referral') ? $package = new RequestSamplePackage : $package = new ReferralSamplePackage;
            $package->fee = $pack->fee;
            $package->sample_id = $request->input('sample_id');
            $package->package_id =$request->input('method_id');
            $package->save();

            return new DefaultResource($package);
        }
    }

    public function destroy(Request $request)
    {
        $data = RequestAnalysis::findOrFail($request->input('id'));
        
        if($data->status == 'Pending'){
            if($data->delete()){
                return new DefaultResource($data);    
            }
        } 
    }

    public function solo($id,$type)
    {   
        $agency = config('app.agency');

        $query = ListTestService::query();
        ($type == 'Referral') ? $query->where('agency_id','!=',$agency) : $query = $query->where('agency_id',$agency);
        $data = $query->where('sampletype_id',$id)->get();

        return AnalysisResource::collection($data);
        // $data = ListTestService::where('agency_id',$agency)->where('sampletype_id',$id)->get();
    }

    public function packages($id,$type)
    {
        $agency = config('app.agency');

        $query = ListPackage::query();
        ($type == 'Referral') ? $query->where('agency_id','!=',$agency) : $query = $query->where('agency_id',$agency);
        $data = $query->where('sampletype_id',$id)->get();

        return PackageResource::collection($data);
        // $data = ListPackage::where('agency_id',$agency)->where('sampletype_id',$id)->get();
    }

    public function solosearch($id,$type,$keyword)
    {   
        $agency = config('app.agency');

        $query = ListTestService::query();
        ($type == 'Referral') ? $query->where('agency_id','!=',$agency) : $query = $query->where('agency_id',$agency);
        $data = $query->where('sampletype_id',$id)->whereHas('testname', function($query) use ($keyword){
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })->get();

        return AnalysisResource::collection($data);
        // $data = ListTestService::where('agency_id',$agency)->where('sampletype_id',$id)->get();
    }
}
