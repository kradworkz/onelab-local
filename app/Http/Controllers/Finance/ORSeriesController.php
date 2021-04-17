<?php

namespace App\Http\Controllers\Finance;

use App\Models\FinanceOrseries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Requests\OrseriesRequest;

class ORSeriesController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $keyword = $request->input('keyword');
        $data = FinanceOrseries::where('name', 'LIKE', '%'.$keyword.'%')->where('type_id',$type)->orderBy('status','ASC')->orderBy('id','DESC')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function store(OrseriesRequest $request)
    {   
        $data = $request->isMethod('put') ? FinanceOrseries::findOrFail($request->input('id')) : new FinanceOrseries;
        $data->name = ucwords(strtolower($request->input('name')));
        $data->start = $request->input('start');
        $data->end = $request->input('end');
        $data->status = 1;
        $data->type_id = $request->input('type');
        $data->save();
        
        return new DefaultResource($data);
    }

    public function status(Request $request)
    {
        $id = $request->input('id');

        $data = FinanceOrseries::where('id',$id)->first();
        $data->status = 0;
        if($data->save()){
            $save = FinanceOrseries::where('id','!=',$id)->where('status','!=',2)->update(['status' => 1]);
        }

        return new DefaultResource($data);
    }
}
