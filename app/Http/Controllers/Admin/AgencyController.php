<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agency;
use App\Models\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\AgencyResource;
use App\Http\Resources\DefaultResource;

class AgencyController extends Controller
{
    public function paginated(Request $request)
    {   
        $type = $request->post('type');
        $data = Agency::where('type_id',$type)->orderBy('id','ASC')->paginate(5);
        return DefaultResource::collection($data);
    }

    public function list($type)
    {
        $data = Agency::where('type_id',$type)->orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function store(Request $request)
    {
        $agencies = $request->input('datas');
        if(!empty($agencies)){
            foreach($agencies as $agency){
                
                $data = new Agency;
                $data->id = $agency['id'];
                $data->name = $agency['name'];
                $data->acronym = $agency['acronym'];
                $data->code = $agency['code'];
                $data->website = $agency['website'];
                $data->type_id = $agency['type']['id'];
                
                if($data->save())
                {   
                    foreach($agency['address'] as $agncy)
                    $data->address()->create([
                        'address' => $agncy['address'],
                        'type' => $agncy['type'],
                        'region_id' => $agncy['region_id'],
                        'province_id' => $agncy['province_id'],
                        'municipality_id' => $agncy['municipality_id'],
                    ]);
                }
            }
        }
        return new AgencyResource($data); 
    }
}
