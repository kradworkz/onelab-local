<?php

namespace App\Http\Controllers\Cro;

use App\Models\Request as R; 
use App\Models\RequestSample;
use App\Models\RequestAnalysis;
use Carbon\Carbon;
use App\Models\DropdownList as DL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TopResource;

class HomeController extends Controller
{
    public function top(){

        $services = \DB::table('requests')
        ->selectRaw('laboratory_id,dropdown_lists.name, count(laboratory_id) as total')
        ->join('dropdown_lists', 'requests.laboratory_id', '=', 'dropdown_lists.id')
        ->groupBy('laboratory_id','dropdown_lists.name')
        ->orderBy('total','DESC')->take(10)->get();

        $samples = \DB::table('request_samples')
        ->selectRaw('sampletype_id,list_sample_tests.name, count(sampletype_id) as total')
        ->join('list_sample_tests', 'request_samples.sampletype_id', '=', 'list_sample_tests.id')
        ->groupBy('sampletype_id','list_sample_tests.name')
        ->orderBy('total','DESC')->take(10)->get();

        $analysis = \DB::table('list_test_services')
        ->selectRaw('testservice_id,list_sample_tests.name, count(testservice_id) as total')
        ->join('request_analyses', 'request_analyses.testservice_id', '=', 'list_test_services.id')
        ->join('list_sample_tests', 'list_sample_tests.id', '=', 'list_test_services.testname_id')
        ->groupBy('testservice_id','list_sample_tests.name')
        ->orderBy('total','DESC')->take(10)->get();

        $dataSet[] = [
            'services' => $services,
            'samples'  => $samples,
            'analysis' =>  $analysis,
        ];

        return $dataSet;
    }

    public function services(){

        $services = DL::select('id','name')->where('type','Laboratory')->where('status',0)->orderBy('id','ASC')->get();

        foreach($services as $service){
            
            $year = 2021;

            $request = R::select('id','created_at')
            ->where('status','Completed')->where('laboratory_id',$service['id'])->whereYear('created_at',$year)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

            $reqcount = [];
        
            foreach ($request as $key => $value) {
                $reqcount[(int)$key] = count($value);
            }

            $a=array();
            for($i = 1; $i <= 12; $i++){
                if(!empty($reqcount[$i])){
                    array_push($a,$reqcount[$i]);
                }else{
                    array_push($a,0);
                }
            }

            $dataservices[] = [  
                'name' => $service['name'],
                'data' => $a
            ];
        }
        return $dataservices;
    }
}
