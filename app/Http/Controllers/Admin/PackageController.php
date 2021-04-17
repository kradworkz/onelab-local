<?php

namespace App\Http\Controllers\Admin;

use App\Models\ListSampleTest;
use App\Models\ListPackage;
use App\Models\ListPackageList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PackageResource;
use App\Http\Resources\DefaultResource;

class PackageController extends Controller
{
    public function index($id)
    {
        $data = ListPackage::where('sampletype_id',$id)->orderBy('id','ASC')->paginate(10);
        return PackageResource::collection($data);
    }

    public function list()
    {
        $data = ListPackage::orderBy('id','ASC')->get();
        return PackageResource::collection($data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $type = $request->input('sampletype');

        $data =  ListPackage::where('sampletype_id',$type)->where('name', 'LIKE', '%'.$keyword.'%')->paginate(10);

        return PackageResource::collection($data);
    }

    public function store(Request $request)
    {
        $lists = $request->input('datas');
        if(!empty($lists)){
            foreach($lists as $list)
            {
                $data = new ListPackage;
                $data->id = $list['id'];
                $data->name = $list['name'];
                $data->fee = $list['fee'];
                $data->agency_id = $list['agency_id'];
                $data->sampletype_id = $list['sampletype_id'];
                if($data->save()){
                    
                    foreach($list['lists'] as $test){
                        $testservice = new ListPackageList;
                        $testservice->id = $test['id'];
                        $testservice->package_id = $test['package_id'];
                        $testservice->testservice_id = $test['testservice_id'];
                        $testservice->save();
                    }
                }
            }
        }
        return new DefaultResource($data); 
    }
}
