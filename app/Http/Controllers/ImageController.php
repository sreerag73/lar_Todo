<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ImageController extends Controller
{
    public function image_add(Request $request)
    {
    $request->validate([
        'name'=>'required',
        'email'=>'required',
        'password'=>'required',
        'image'=>'mimes:jpeg,jpg,png,gif|max:2048',
    ]);
    $data=$request->all();
    $path='asset/storage/images/'.$data['image'];
    $fileName=time().$request->file('image')->getClientoriginalName();
    $path=$request->file('image')->storeAs('image',$fileName,'public');
    $datas["image"]='/storage/'.$path;
    $data['image']=$fileName;
    $data['password']=bcrypt($request->password);
    $user=User::create($data);
    return response()->json([
        'status'=>'true',
        'message'=>'user created successfully',
        'token'=>$user->createToken("API TOKEN")->plainTextToken],200);
}
}
