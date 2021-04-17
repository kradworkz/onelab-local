<?php

namespace App\Http\Controllers\Cro;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Agency;
use App\Models\RequestSample;
use App\Models\RequestAnalysis;
use App\Models\Request as LabRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request){
        $type = $request->input('type');
        $laboratory = $request->input('laboratory');
        $month = $request->input('month');
        $year = $request->input('year');
        $todate = $request->input('todate');

        if($month == 'All'){
            $request = LabRequest::select('id', 'created_at','laboratory_id')
            ->where('status','Completed')->where('laboratory_id',$laboratory)->whereYear('created_at',$year)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

            $reqcount = []; $reqids = [];
            
            foreach ($request as $key => $value) {
                $reqcount[(int)$key] = count($value);
                $reqids[(int)$key] = $value;
            }
            
            for($i = 1; $i <= 12; $i++){
                if(!empty($reqcount[$i])){

                    $ids = $reqids[$i]->pluck('id');
                    $sample = RequestSample::whereIn('request_id',$ids)->pluck('id');
                    $analysis = RequestAnalysis::whereIn('sample_id',$sample)->count();
                    $data = Cart::whereIn('cartable_id',$ids)->get();
                    $samples = $sample->count();
                    $subtotal =  $data->sum('subtotal');
                    $discount =  $data->sum('discount');
                    $gratis = $data->where('total',0.00)->sum('subtotal');

                    $dataSet[$i] = [
                        'month'  => date('F', mktime(0, 0, 0, $i, 10)),
                        'requests'  => $reqcount[$i],
                        'samples' => $samples,
                        'analysis' => $analysis,
                        'gross' => $subtotal, 
                        'discount' => $discount,
                        'gratis' => $gratis,
                        'income' => $subtotal-($discount+$gratis),
                    ];
                }else{
                    $dataSet[$i] = [
                        'month' => date('F', mktime(0, 0, 0, $i, 10)),
                        'requests'  => 0,
                        'samples' =>  0,
                        'analysis' => 0,
                        'gross' => 0,
                        'discount' => 0,
                        'gratis' => 0,
                        'income' => 0,
                    ];
                }
            }
        }else{
        
            if($month == 'Daily'){
                $ids = LabRequest::select('id', 'created_at','laboratory_id','status')
                ->where('status','Completed')->where('laboratory_id',$laboratory)->whereDate('created_at',$todate)
                ->pluck('id');
            }else{
                $ids = LabRequest::select('id', 'created_at','laboratory_id','status')
                ->where('status','Completed')->where('laboratory_id',$laboratory)->whereMonth('created_at',$month)
                ->pluck('id');
            }

            $sample = RequestSample::whereIn('request_id',$ids)->pluck('id');
            $analysis = RequestAnalysis::whereIn('sample_id',$sample)->count();
            $data = Cart::whereIn('cartable_id',$ids)->get();
            $samples = $sample->count();
            $subtotal =  $data->sum('subtotal');
            $discount =  $data->sum('discount');
            $gratis = $data->where('total',0.00)->sum('subtotal');

            $dataSet[] = [
                'month'  => $month,
                'requests'  => $ids->count(),
                'samples' => $samples,
                'analysis' => $analysis,
                'gross' => $subtotal, 
                'discount' => $discount,
                'gratis' => $gratis,
                'income' => $subtotal-($discount+$gratis),
            ];
        }
        
        return $dataSet;
    }

    public function print(){

        $type = 'Daily';
        $laboratory = 38;
        $status = 'All';
        $month = date('m');
        $year =  date('Y');
        $date = date('Y-m-d');

        $request = LabRequest::select('id', 'created_at','laboratory_id')
        ->where('laboratory_id',$laboratory)
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $reqcount = []; $reqids = [];
        
        foreach ($request as $key => $value) {
            $reqcount[(int)$key] = count($value);
            $reqids[(int)$key] = $value;
        }
        
        for($i = 1; $i <= 12; $i++){
            if(!empty($reqcount[$i])){

                $ids = $reqids[$i]->pluck('id');
                $sample = RequestSample::whereIn('request_id',$ids)->pluck('id');
                $analysis = RequestAnalysis::whereIn('sample_id',$sample)->count();
                $data = Cart::whereIn('cartable_id',$ids)->get();
                $samples = $sample->count();
                $subtotal =  $data->sum('subtotal');
                $discount =  $data->sum('discount');
                $gratis = $data->where('total',0.00)->sum('subtotal');

                $dataSet[$i] = [
                    'month'  => date('F', mktime(0, 0, 0, $i, 10)),
                    'requests'  => $reqcount[$i],
                    'samples' => $samples,
                    'analysis' => $analysis,
                    'gross' => number_format($subtotal,2), 
                    'discount' => number_format($discount,2), 
                    'gratis' => number_format($gratis,2), 
                    'income' => number_format($subtotal-($discount+$gratis),2), 
                ];
            }else{
                $dataSet[$i] = [
                    'month' => date('F', mktime(0, 0, 0, $i, 10)),
                    'requests'  => 0,
                    'samples' =>  0,
                    'analysis' => 0,
                    'gross' => 0,
                    'discount' => 0,
                    'gratis' => 0,
                    'income' => 0,
                ];
            }
        }
        
        $data = [
            'dataset'    => $dataSet,
        ];

        $pdf = \PDF::loadView('user_cro.print-report',$data);
        return $pdf->download('invoice.pdf');
    }

    public function printtest(){

        $type = 'Daily';
        $laboratory = 38;
        $status = 'All';
        $month = date('m');
        $year =  date('Y');
        $date = date('Y-m-d');

        $request = LabRequest::select('id', 'created_at','laboratory_id')
        ->where('laboratory_id',$laboratory)
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $reqcount = []; $reqids = [];
        
        foreach ($request as $key => $value) {
            $reqcount[(int)$key] = count($value);
            $reqids[(int)$key] = $value;
        }
        
        for($i = 1; $i <= 12; $i++){
            if(!empty($reqcount[$i])){

                $ids = $reqids[$i]->pluck('id');
                $sample = RequestSample::whereIn('request_id',$ids)->pluck('id');
                $analysis = RequestAnalysis::whereIn('sample_id',$sample)->count();
                $data = Cart::whereIn('cartable_id',$ids)->get();
                $samples = $sample->count();
                $subtotal =  $data->sum('subtotal');
                $discount =  $data->sum('discount');
                $gratis = $data->where('total',0.00)->sum('subtotal');

                $dataSet[$i] = [
                    'month'  => date('F', mktime(0, 0, 0, $i, 10)),
                    'requests'  => $reqcount[$i],
                    'samples' => $samples,
                    'analysis' => $analysis,
                    'gross' => number_format($subtotal,2), 
                    'discount' => number_format($discount,2), 
                    'gratis' => number_format($gratis,2), 
                    'income' => number_format($subtotal-($discount+$gratis),2), 
                ];
            }else{
                $dataSet[$i] = [
                    'month' => date('F', mktime(0, 0, 0, $i, 10)),
                    'requests'  => 0,
                    'samples' =>  0,
                    'analysis' => 0,
                    'gross' => 0, 
                    'discount' => 0,
                    'gratis' => 0,
                    'income' => 0,
                ];
            }
        }

        return view('user_cro.print-report')->with('dataset',$dataSet);
    }
}
