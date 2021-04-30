<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use File;

class UserController extends Controller
{
    public function index () {
        $users = User::all();
        if($users) {
            $data = [];
            foreach ($users as $key => $value) {
                $user['id']  = $value->id;
                $user['name'] = $value->name;
                $user['email'] = $value->email;
                $user['address'] = $value->address;
                $user['created_at'] = $value->created_at->diffForHumans();
                if($value->image){
                    $user['image'] = url('public/images/'.$value->image);
                }
                else{
                    $user['image'] = url('public/images/dummy-profile.jpg');
                }
                array_push($data, $user);
            }
            return response()->json(['data'=> $data, 'response'=> true, 'message'=> 'Users successfully getting.']);
        } else {
            return response()->json(['response'=> false, 'message'=> 'Users not found.']);
        }
    }   

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'address'  => 'required',
            // 'image'    => 'image|mimes:jpg,png,jpeg,svg',
        ]);

        if($validator->fails()){
            return response()->json(['response'=> false, 'message'=> 'Validation errors.', 'errors' => $validator->errors()]);       
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        if($request->hasFile('image')) 
        {
            $validator = Validator::make($request->all(), [
                'image'    => 'image|mimes:jpg,png,jpeg,svg',
            ]);
            if($validator->fails()){
                return response()->json(['response'=> false, 'message'=> 'Validation errors.', 'errors' => $validator->errors()]);       
            }
            $dirPath = 'public/images/';
            $publicPath = 'images/';
            if (!file_exists($dirPath)) {
                
                File::makeDirectory(public_path().'/'.$publicPath,0777,true);
            }
            File::delete('public/images/'.$request->image);
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images/');
            $image->move($destinationPath, $name);
            $user->image    = $name;
        } else {
            $user->image    = 'dummy-profile.jpg';
        }
        if($user->save()) {
            if($user->image){
                $user['image'] = url('public/images/'.$user->image);
            }
            else{
                $user['image'] = url('public/images/dummy-profile.jpg');
            }
            return response()->json(['data' => $user, 'response'=> true, 'message'=> 'User register successfully.']);
        } else {
            return response()->json(['response'=> false, 'message'=> 'something went wrong.']);       
        }
    }

    public function edit ($id) {

        if($id) {
            $user = User::findOrFail($id);
            if($user) {
                if($user->image){
                    $user['image'] = url('public/images/'.$user->image);
                }
                else{
                    $user['image'] = url('public/images/dummy-profile.jpg');
                }
                return response()->json(['data' => $user, 'response'=> true, 'message'=> 'User detail successfully get.']);
            } else {
                return response()->json(['response'=> false, 'message'=> 'something went wrong.']);
            }
        } else {
            return response()->json(['response'=> false, 'message'=> 'something went wrong.']);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            // 'image'    => 'image|mimes:jpg,png,jpeg,svg',
        ]);

        if($validator->fails()){
            return response()->json(['response'=> false, 'message'=> 'Validation errors.', 'errors' => $validator->errors()]);       
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        if($request->hasFile('image')) 
        {
            $validator = Validator::make($request->all(), [
                'image'    => 'image|mimes:jpg,png,jpeg,svg',
            ]);
            if($validator->fails()){
                return response()->json(['response'=> false, 'message'=> 'Validation errors.', 'errors' => $validator->errors()]);       
            }
            $dirPath = 'public/images/';
            $publicPath = 'images/';
            if (!file_exists($dirPath)) {
                
                File::makeDirectory(public_path().'/'.$publicPath,0777,true);
            }
            File::delete('public/images/'.$request->image);
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images/');
            $image->move($destinationPath, $name);
            $user->image  = $name;
        }
        else
        {
            $user->image    =   $user->image;
        }
        if($user->save()) {
            if($user->image){
                $user['image'] = url('public/images/'.$user->image);
            }
            else{
                $user['image'] = url('public/images/dummy-profile.jpg');
            }
            return response()->json(['data' => $user, 'response'=> true, 'message'=> 'User updated successfully.']);
        } else {
            return response()->json(['response'=> false, 'message'=> 'something went wrong.']);
        }
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['response'=> true, 'message'=> 'User deleted successfully.']);
    }
}
