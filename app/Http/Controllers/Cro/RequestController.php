<?php

namespace App\Http\Controllers\Cro;

use Auth;
use App\Models\Agency;
use App\Models\Request as LabRequest;
use App\Models\RequestSample;
use App\Models\ReferralSample;
use App\Models\RequestAnalysis;
use App\Models\ReferralAnalysis;
use App\Models\FinanceTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Cro\RequestResource;
use App\Http\Requests\RequestRequest;
use App\Http\Resources\DefaultResource;
use Illuminate\Support\Facades\Http;

class RequestController extends Controller
{
    public function index()
    {
        $data = LabRequest::orderBy('id','DESC')->paginate(10);
        return RequestResource::collection($data);
    }

    public function list()
    {
        $data = LabRequest::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }
    
    public function store(RequestRequest $request)
    {
        // $lab_id = Auth::user()->profile->laboratory_id;
        $data = $request->isMethod('put') ? LabRequest::findOrFail($request->input('id')) : new LabRequest;
        $data->report_due = $request->input('duedate');
        $data->type_id = $request->input('type');
        $data->laboratory_id =$request->input('laboratory');
        $data->purpose_id = $request->input('purpose');
        $data->from_id = $request->input('from');
        $data->discount_id = $request->input('discount');
        $data->modeofrelease_id = $request->input('mode');
        $data->customer_id = $request->input('customer');
        $data->conforme_id = $request->input('conforme');
        
        if($data->save()){
            $count = FinanceTransaction::where('status','Pending')->where('customer_id',$request->input('customer'))->count();

            if($count < 1){
                $transaction = new FinanceTransaction;
                $transaction->transaction_no = 'T#'.$request->input('agency').'-'.date('mdyhms');
                $transaction->status = 'Pending';
                $transaction->customer_id = $request->input('customer');
                $transaction->collection_id = config('app.collection_id');
                $transaction->save();
            }
        }

        return new RequestResource($data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('word');
        $type = $request->input('type');
        $from = $request->input('from');

        $data = LabRequest::where('type_id',$type)->where('from_id',$from)
        ->where(function ($query) use ($keyword) {
            $query->where('reference', 'LIKE', '%'.$keyword.'%')
                ->orWhereHas('customer',function($query) use ($keyword) {
                $query->where('address', 'LIKE', '%'.$keyword.'%')
                ->orWhereHas('addressable',function($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            });
        })
        ->orderBy('id','DESC')->paginate(10);

        return RequestResource::collection($data);
    }

    public function destroy($id)
    {
        $data = LabRequest::findOrFail($id);
        if($data->delete()){
            return new DefaultResource($data);   
        }
    }

    public function view($id)
    {
        $data = LabRequest::where('id',$id)->first();
        return new RequestResource($data);
    }

    public function update(Request $request) 
    {
        \DB::transaction(function () use ($request){
            $agency_id = config('app.agency');
            $agency = Agency::where('id',$agency_id)->first();
            $id = $request->input('id');
            $token = $request->input('token');

            $req = LabRequest::findOrFail($id);
            $count = LabRequest::where('reference','!=','n/a')->where('laboratory_id',$req->laboratory_id)->whereYear('created_at',date('Y'))->count();

            $req->reference = $agency->code.'-'.date('mdy').'-'.$req->laboratory->code.'-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);
            $req->status = 'Waiting';
            
            if($req->save()){

                if($req->type_id == config('app.referral_id'))
                {
                    $samples = ReferralSample::where('request_id',$req->id)->pluck('id');
                    $analyses = ReferralAnalysis::whereIn('sample_id',$samples)->get();
                    
                    $content[] = [
                        'request' => [
                            'agency' => config('app.agency'),
                            'reference' => $req->reference,
                            'laboratory_id' => $req->laboratory_id,
                            'purpose_id' => $req->purpose_id,
                            'discount_id' => $req->discount_id,
                            'from_id' => $req->from_id,
                            'report_due' => $req->report_due,
                        ],
                        'customer' => [
                            'id' => ($req->customer->addressable->address->count() > 1) ? $req->customer->addressable->id : $req->customer->id ,
                            'name' => ($req->customer->addressable->address->count() > 1) ? $req->customer->addressable->name.' - '.$req->customer->address : $req->customer->addressable->name ,
                            'email' => $req->customer->addressable->user->email,
                            'conforme' => $req->conforme->name,
                            'conforme_mobile' => $req->conforme->mobile_no,
                        ],
                        'samples' => $req->referralsamples,
                        'analyses' => $analyses
                    ];


                    try{
                        $response = Http::withToken($token)
                        ->withHeaders([
                            'KradWorks' => 'XNndUUEA95BKwQ2blrLbYcU0IRCb5YQW',
                        ])->post('http://one.main/api/request', [
                            'reference' => $req->reference,
                            'content' => $content,
                            'from' => config('app.agency'),
                            'to' => $analyses[0]->testservice->agency_id
                        ]);

                        if (!$response->successful()){
                            dd($response->throw());
                        }

                    } catch(\Exception $e){
                        
                    }

                }else{
                    foreach($req->samples as $smpls){
                        $count = RequestSample::where('code','!=','n/a')->where('laboratory_id',$req->laboratory_id)->count();
                        
                        $data = RequestSample::findOrFail($smpls->id);
                        $data->code = $req->laboratory->code.'-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);
                        $data->save();
                    }
                }
            }
            return new DefaultResource($req); 
        });
    }

    public function testing($id){
        
        $req = LabRequest::findOrFail($id);
        $samples = RequestSample::where('request_id',$req->id)->pluck('id');
        $analyses = ReferralAnalysis::whereIn('sample_id',$samples)->get();
        
        $content[] = [
            'request' => [
                'agency' => config('app.agency'),
                'reference' => $req->reference,
                'laboratory_id' => $req->laboratory_id,
                'purpose_id' => $req->purpose_id,
                'discount_id' => $req->discount_id,
                'from_id' => $req->from_id,
                'report_due' => $req->report_due,
            ],
            'customer' => [
                'id' => ($req->customer->addressable->address->count() > 1) ? $req->customer->addressable->id : $req->customer->id ,
                'name' => ($req->customer->addressable->address->count() > 1) ? $req->customer->addressable->name.' - '.$req->customer->address : $req->customer->addressable->name ,
                'email' => $req->customer->addressable->user->email,
                'conforme' => $req->conforme->name,
                'conforme_mobile' => $req->conforme->mobile_no,
            ],
            'samples' => $req->samples,
            'analyses' => $analyses
        ];

        $response = Http::post('https://one.main/api/request', [
            'reference' => $req->reference,
            'content' => json_encode($content),
            'from' => config('app.agency'),
            'to' => $analyses[0]->testservice->agency_id
        ]);

        return $response->successful();
    }
}
