<?php

namespace App\Http\Controllers\Cro;

use Auth;
use App\Models\ListSampleTest;
use App\Models\ListPackage;
use App\Models\ListPackageList;
use App\Models\ListTestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Lab\SampletypeResource;

class TestserviceController extends Controller
{
    public function sampletypes($id)
    {
        ($id == null) ? $id = Auth::user()->profile->laboratory_id : $id;
        $data = ListSampleTest::where('name','!=','-')->where('laboratory_id',$id)->where('type','Sampletype')->orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function sampletype(Request $request)
    {
        $laboratory = ($request->input('laboratory') == null) ? Auth::user()->profile->laboratory_id : $request->input('laboratory') ;
        $keyword = $request->input('word');
        $type = $request->input('type');
        $agency_id = config('app.agency');
        // ($type == 'Referral') ? : ;
        
        // $data = ListSampleTest::where('name','like','%'.$keyword.'%')->where('name','!=','-')->where('laboratory_id',$laboratory)->where('type','Sampletype')->orderBy('id','ASC')->get();
        // return DefaultResource::collection($data);


        // $query = ListSampleTest::query();

        // $query = $query->whereIn('status',['Ongoing','Finished'])
        // ->whereHas('tag', function($query){
        //     $query->where('user_id', Auth::user()->id);
        // });

        // if($type == 'Weekly'){
        //     $query =  $query->whereBetween('created_at', [Carbon::parse('last monday')->startOfDay(),Carbon::parse('next friday')->endOfDay()]);
        // }else if($type == 'Monthly'){
        //     $query = $query->whereMonth('created_at',date('m'));
        // }else{
        //     $query = $query->whereYear('created_at',date('Y'));
        // }

        // $data = $query->get();

        $query = ListTestService::query();

        if($type == 'Referral'){
            $query =  $query->where('agency_id','!=',$agency_id);
        }else{
            $query =  $query->where('agency_id',$agency_id);
        }
        $query->select('sampletype_id')->whereHas('sampletype',function ($query) use ($keyword,$laboratory) {
            $query->where('name', 'LIKE', '%'.$keyword.'%')
            ->where('laboratory_id', $laboratory);
        })->take(3)->groupBy('sampletype_id');

        $data = $query->get();

        return SampletypeResource::collection($data);

    }

    public function lists()
    {
        $id = Auth::user()->profile->laboratory_id;
        $data = ListSampleTest::where('name','!=','-')->where('laboratory_id',$id)->where('type','Sampletype')->orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }
}
