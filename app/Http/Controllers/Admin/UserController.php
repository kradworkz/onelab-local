<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\Admin\StaffResource;
use App\Http\Requests\StaffRequest;

class UserController extends Controller
{
    public function index(Request $request){

        $keyword = $request->input('word');

        $users =  User::whereIn('type',['Administrator','Lab Analyst','Lab Manager','Cashier', 'Accountant', 'Customer Relations Officer'])
        ->where(function ($query) use ($keyword) {
            $query->where('email', 'LIKE', '%'.$keyword.'%')
            ->orWhereHas('profile',function($query) use ($keyword) {
                return $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%');
            });
        })
        ->paginate(8);
        
        return StaffResource::collection($users);

    }

    public function store(StoreImage $strmg, StaffRequest $request){

        $user = $request->isMethod('put') ? User::findOrFail($request->input('id')) : new User;

        $user->email = strtolower($request->input('email'));
        $user->type = $request->input('type');
        $user->password = bcrypt(123456789);

        if($user->save()){

            $name = strtolower($request->input('firstname')).'-'.$user->id;
            if($request->input('avatar') != ''){
                $imageName = $strmg->strmg($request->input('avatar'),$name);
            }else{
                $request->isMethod('put') ? $imageName = $user->profile->avatar : $imageName = 'avatar.jpg';
            }

            if($request->isMethod('put')){
                $user->profile()->update([
                    'firstname' => ucwords(strtolower($request->input('firstname'))),
                    'lastname' => ucwords(strtolower($request->input('lastname'))),
                    'gender' => $request->input('gender'),
                    'birthday' => $request->input('birthday'),
                    'laboratory_id' => $request->input('laboratory'),
                    'avatar' => $imageName
                ]);
            }else{
                $user->profile()->create([
                    'firstname' => ucwords(strtolower($request->input('firstname'))),
                    'lastname' => ucwords(strtolower($request->input('lastname'))),
                    'gender' => $request->input('gender'),
                    'birthday' => $request->input('birthday'),
                    'laboratory_id' => $request->input('laboratory'),
                    'avatar' => $imageName
                ]);
            }
        }

        return new StaffResource($user);

    }

    public function status(Request $request){

        $user = User::findOrFail($request->input('id'));
        $user->status = $request->input('type');
        $user->save();

        return new StaffResource($user);

    }

    public function password(Request $request){

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json(['error' => "Password doesn't match."], 401);
        }

        if(strcmp($request->get('current_password'), $request->get('password')) == 0){
            return response()->json(['error' => 'Please choose a different password'], 401);
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:9|confirmed',
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->input('password'))]);

        if(Auth::user()->status == 'Inactive'){
            User::find(auth()->user()->id)->update(['status'=> 'Active']);
            return response()->json(['success' => 'First Attempt'], 200);
        }else{
            return response()->json(['success' => 'Password changed successfully !'], 200);
        }

    }
}
