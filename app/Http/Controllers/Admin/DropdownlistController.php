<?php

namespace App\Http\Controllers\Admin;

use App\Models\DropdownList as DL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class DropdownlistController extends Controller
{
    public function paginated(Request $request)
    {   
        $type = $request->post('type');
        $data = DL::where('type',$type)->orderBy('id','ASC')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function list($type)
    {
        $data = DL::where('type',$type)->orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function lists(Request $request)
    {
        $type = $request->input('type');
        $keyword = $request->input('keyword');
        $data = DL::where('name', 'LIKE', '%'.$keyword.'%')->where('type',$type)->orderBy('id','ASC')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function active($type)
    {
        $data = DL::select('id','name')->where('type',$type)->where('status',0)->orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }
    
    public function store(Request $request)
    {
        $lists = $request->input('datas');
        if(!empty($lists)){
            foreach($lists as $list)
            {
                $data = new DL;
                $data->id = $list['id'];
                $data->name = $list['name'];
                ($list['type'] == 'Agency Type' || $list['type'] == 'Laboratory') ? $data->code = $list['code'] : '';
                ($list['type'] == 'Discount') ? $data->percentage = $list['percentage'] : '';
                $data->type = $list['type'];
                $data->save();
            }
        }
        return new DefaultResource($data); 
    }

    public function status(Request $request)
    {
        $id = $request->input('id');
        ($request->input('status') == 0) ? $status = 1 : $status = 0;

        $data = DL::where('id',$id)->first();
        $data->status = $status;
        $data->save();

        return new DefaultResource($data);
    }
}
