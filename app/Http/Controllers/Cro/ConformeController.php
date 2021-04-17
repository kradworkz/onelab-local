<?php

namespace App\Http\Controllers\Cro;

use App\Models\Conforme;
use App\Models\CustomerConforme;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Cro\ConformeResource;
use App\Http\Requests\ConformeRequest;

class ConformeController extends Controller
{
    public function index()
    {
        $data = CustomerConforme::orderBy('id','ASC')->paginate(5);
        return DefaultResource::collection($data);
    }

    public function list($id)
    {
        $data = CustomerConforme::where('customer_id',$id)->orderBy('id','ASC')->get();
        return ConformeResource::collection($data);
    }
    
    public function store(ConformeRequest $request)
    {   
        $conforme = $request->isMethod('put') ? Conforme::findOrFail($request->input('id')) : new Conforme;
        $conforme->name = ucwords(strtolower($request->input('name')));
        $conforme->mobile_no = $request->input('mobile');
        
        if($conforme->save()){
            $data = $request->isMethod('put') ? CustomerConforme::findOrFail($request->input('id')) : new CustomerConforme;
            $data->customer_id = $request->input('customer');
            $data->conforme_id = $conforme->id;
            $data->save();
        }
        return new DefaultResource($data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('word');
        $data = CustomerConforme::where('name','like','%'.$keyword.'%')->paginate(5);

        return DefaultResource::collection($data);
    }

    public function destroy($id)
    {
        $data = CustomerConforme::findOrFail($id);
        if($data->delete()){
            return new DefaultResource($data);   
        }
    }
}
