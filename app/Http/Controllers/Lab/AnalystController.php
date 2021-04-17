<?php

namespace App\Http\Controllers\Lab;

use Auth;
use Carbon\Carbon;
use App\Models\Request as LabRequest;
use App\Models\RequestAnalysis;
use App\Models\RequestAnalysisTag;
use App\Models\RequestSamplePackage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Lab\AnalysisResource;
use App\Http\Resources\Lab\ViewAnalysisResource;

class AnalystController extends Controller
{
    public function urgent($status)
    {
        $date = Carbon::now()->addDays(2)->format( 'Y-m-d' );
        $lab_id = Auth::user()->profile->laboratory_id;

        $data = RequestAnalysis::where('status',$status)
        ->whereHas('sample',function ($query) use ($lab_id, $date) {
            $query->where('laboratory_id',$lab_id)
            ->whereHas('request',function($query) use($date){
                return $query->where('report_due', '<=' ,$date);
            });
        })
        ->paginate(10);

        return AnalysisResource::collection($data);
    }

    public function chill($status)
    {
        $date = Carbon::now()->addDays(2)->format( 'Y-m-d' );
        $lab_id = Auth::user()->profile->laboratory_id;

        $data = RequestAnalysis::where('status',$status)
        ->whereHas('sample',function ($query) use ($lab_id, $date) {
            $query->where('laboratory_id',$lab_id)
            ->whereHas('request',function($query) use($date){
                return $query->where('report_due', '>' ,$date);
            });
        })
        ->paginate(10);

        return AnalysisResource::collection($data);
    }

    public function paginated($sampletype_id,$status)
    {
        $lab_id = Auth::user()->profile->laboratory_id;
        ($status == 'all') ? $status = '' : $status;
        if($sampletype_id == 'all'){
            $data = RequestAnalysis::where('status','LIKE','%'.$status.'%')
            ->whereHas('sample',function ($query) use ($lab_id) {
                $query->where('laboratory_id',$lab_id);
            })
            ->orderBy('created_at','DESC')->paginate(10);
        }else{
            $data = RequestAnalysis::where('status','LIKE','%'.$status.'%')
            ->whereHas('sample',function ($query) use ($lab_id,$sampletype_id) {
                $query->where('laboratory_id',$lab_id)
                    ->where('sampletype_id',$sampletype_id);
            })
            ->orderBy('created_at','DESC')->paginate(10);
        }

        return AnalysisResource::collection($data);
    }

    public function status(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $data = RequestAnalysis::where('id',$id)->first();
        $data->status = $status;

        if($data->save()){
            
            $sample_id = $data->sample_id;

            $count = RequestAnalysis::where('sample_id',$sample_id)->whereIn('status',['Pending','Ongoing'])->count();

            if($count < 1){
                $request_id = $data->sample->request->id;
                $request = LabRequest::where('id',$request_id)->first();
                $request->status = 'Completed';
                $request->save();
            }

            if($status == 'Ongoing'){
                $data->tag()->create([
                    'start' => now(),
                    'user_id' => Auth::user()->id
                ]);
            }else{
                $data->tag()->update([
                    'end' => now()
                ]);
            }

            if($data->is_package == 0){
                $package_id = $data->package_id;

                $count = RequestAnalysis::where('sample_id',$sample_id)->where('package_id',$package_id)->whereIn('status',['Pending','Ongoing'])->count();

                $sample = RequestSamplePackage::where('sample_id',$sample_id)->where('package_id',$package_id)->first();
                ($count < 1) ? $sample->status = 'Completed' : $sample->status = 'Ongoing';
                $sample->save();
            }
        }

        return new AnalysisResource($data);
    }

    public function search($sampletype,$status,$keyword)
    {   
        ($status == 'all') ? $status = '' : $status;
        ($keyword == 'all') ? $keyword = '' : $keyword;
        $lab_id = Auth::user()->profile->laboratory_id;

        if($sampletype == 'all'){

          
            $datas = RequestAnalysis::whereHas('sample',function ($query) use ($lab_id,$keyword) {
                $query->where('laboratory_id',$lab_id)
                ->where(function ($query) use ($keyword) {
                    $query->orWhere('code', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->orWhereHas('testservice', function ($query) use ($keyword){
                $query->whereHas('testname', function($query) use ($keyword){
                    $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })->orderBy('created_at','DESC')->pluck('id');

            
            $data = RequestAnalysis::where('status','LIKE','%'.$status.'%')->whereIn('id',$datas)->orderBy('created_at','DESC')->paginate(5);

            
        }else{

            $datas = RequestAnalysis::whereHas('sample',function ($query) use ($lab_id,$sampletype,$keyword) {
                $query->where('laboratory_id',$lab_id)
                    ->where('sampletype_id',$sampletype)
                    ->where(function ($query) use ($keyword) {
                        $query->where('code', 'LIKE', '%'.$keyword.'%');
                    });
            })
            ->orWhereHas('testservice', function ($query) use ($keyword,$sampletype){
                $query->where('sampletype_id',$sampletype)
                    ->whereHas('testname', function($query) use ($keyword){
                        $query->where('name', 'LIKE', '%'.$keyword.'%');
                    });
            })->orderBy('created_at','DESC')->pluck('id');

            $data = RequestAnalysis::where('status','LIKE','%'.$status.'%')->whereIn('id',$datas)->paginate(5);
        }

        return ViewAnalysisResource::collection($data);
    }

    public function todolist($type)
    {   
     
        $date = date('Y-m-d');
        $query = RequestAnalysis::query();

        $query = $query->whereIn('status',['Ongoing','Completed'])
        ->whereHas('tag', function($query){
            $query->where('user_id', Auth::user()->id);
        });

        if($type == 'Weekly'){
            $query =  $query->whereBetween('created_at', [Carbon::parse('last monday')->startOfDay(),Carbon::parse('next friday')->endOfDay()]);
        }else if($type == 'Monthly'){
            $query = $query->whereMonth('created_at',date('m'));
        }else{
            $query = $query->whereYear('created_at',date('Y'));
        }

        $data = $query->get();

        return AnalysisResource::collection($data);
    }
}
