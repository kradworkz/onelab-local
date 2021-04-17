<?php

namespace App\Http\Controllers\Admin;

use App\Models\ListSampleTest;
use App\Models\ListMethodRef;
use App\Models\ListTestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\TestServiceResource;

class TestServiceController extends Controller
{
    public function paginated($id)
    {
        $data = ListTestService::where('sampletype_id',$id)->orderBy('id','DESC')->paginate(10);
        return TestServiceResource::collection($data);
    }

    public function list()
    {
        $data = ListTestService::orderBy('id','DESC')->get();
        return TestServiceResource::collection($data);
    }

    public function addons()
    {
        $data = ListTestService::where('sampletype_id',1)->where('testname_id',1)->orderBy('id','DESC')->paginate(10);
        return TestServiceResource::collection($data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $type = $request->input('sampletype');

        $data =  ListTestService::where('sampletype_id',$type)
        ->whereHas('method',function($query) use ($keyword) {
            return $query->where('name', 'LIKE', '%'.$keyword.'%');
        })->paginate(10);

        return TestServiceResource::collection($data);
    }

    public function store(Request $request)
    {
        $lists = $request->input('datas');
        if(!empty($lists)){
            foreach($lists as $list)
            {
                
                $countst = ListSampleTest::where('id',$list['sampletype_id'])->count();

                if($countst < 1){
                    $st = new ListSampleTest;
                    $st->id = $list['sampletype_id'];
                    $st->name = $list['sampletype'];
                    $st->type = 'Sampletype';
                    $st->laboratory_id = $list['laboratory_id'];
                    $st->save();
                }

                $countst = ListSampleTest::where('id',$list['testname_id'])->count();

                if($countst < 1){
                    $st = new ListSampleTest;
                    $st->id = $list['testname_id'];
                    $st->name = $list['testname'];
                    $st->type = 'Testname';
                    $st->laboratory_id = $list['laboratory_id'];
                    $st->save();
                }

                $countst = ListMethodRef::where('id',$list['method_id'])->count();

                if($countst < 1){
                    $mf = new ListMethodRef;
                    $mf->id = $list['method_id'];
                    $mf->name = $list['method'];
                    $mf->type = 'Method';
                    $mf->laboratory_id = $list['laboratory_id'];
                    $mf->save();
                }

                $countst = ListMethodRef::where('id',$list['reference_id'])->count();

                if($countst < 1){
                    $mf = new ListMethodRef;
                    $mf->id = $list['reference_id'];
                    $mf->name = $list['reference'];
                    $mf->type = 'Reference';
                    $mf->laboratory_id = $list['laboratory_id'];
                    $mf->save();
                }

                $data = new ListTestService;
                $data->id = $list['id'];
                $data->agency_id = $list['agency_id'];
                $data->sampletype_id = $list['sampletype_id'];
                $data->testname_id = $list['testname_id'];
                $data->method_id = $list['method_id'];
                $data->reference_id = $list['reference_id'];
                $data->fee =  $list['fee'];
                $data->save();
            }
        }
        return new DefaultResource($data); 
    }

    public function sampletypes($id)
    {
        $data = ListSampleTest::where('laboratory_id',$id)->where('name','!=','-')->where('type','Sampletype')->orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }
}
