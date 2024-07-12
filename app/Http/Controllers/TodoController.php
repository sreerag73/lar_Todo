<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;


class TodoController extends Controller
{
    public function create_user(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=> 'required|email',
            'password'=>'required|min:8',
        ]);
       $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'User creater successfully',
            'token'=>$user->createToken("API TOKEN")->plainTextToken],200);
    }
    public function view_user()
    {
        $user = User::all();
        return response()->json($user);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);
        if(!Auth::attempt($request->only(['email','password'])))
        {
            return response()->json([
                'status'=>false,
                'message'=>'Email and password does not match with oru record'
            ],401);
        }
        $user=User::where('email',$request->email)->first();
        return response()->json([
            'status'=>true,
            'user'=>$user,
            'message'=>'user logged in successfully',
            'token'=>$user->createToken('API token of'.$user->name,['*'])->plainTextToken],200);
    }
    public function profile_view() 
    {
        $user = Auth::user();
        return response()->json([
            'status'=>true,
            'user'=>$user,
        ],200);
    }
    public function logout()
    {
        $user =Auth::user()->id;
        $id = User::find($user);
        $id->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'user logout successfully'
        ]);
    }
    public function view_task()
    {
        $task= Task::all();
        return response()->json($task);
    }
    public function users_task()
    {
        $user =Auth::user();
        $id=$user->id;

        $task = Task::where('user_id','=',$id)->get();
        return response()->json($task);
    }
    public function update_task(Request $request,$task_id)
    {
        $request->validate([
            'title'=>'required|string',
            'discription'=>'required|string',
            'date'=>'required|date',
        ]);
        $task=Task::find($task_id);
        if(!$task){
            return response()->json([
                'status'=>false,
                'message'=>'Task not found',
            ],404);
        }
        $task->title=$request->title;
        $task->discription=$request->discription;
        $task->date=$request->date;

        $task->update();

    return response()->json([
        'status'=>true,
        'message'=>'Task Updated Successfully',
        'task'=>$task,
    ],200);
    }
    public function delete_task($task_id)
    {
        $task=Task::find($task_id)->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Task Deleted Successfully',
        ],200);
    }
    // public function select($task_id)
    public function select()
    {
        // $id=Task::find($task_id);
        // $hh=$id->task_id;
        // $task=Task::where('task_id','=',$hh)->get();
        // $task=Task::where('task_id','<',$hh)->get();
        // $task=Task::where('task_id','<=',$hh)->get();
        // $task=Task::where('task_id','!=',$hh)->get();

        // $task=DB::table('users')->where('name','amban')->first();
        // $task=Task::whereBetween('task_id',[1,2])->get();
        // $task=DB::table('users')->where('name','like','%abhi%')->get();
        // $task=DB::table('users')->orderBy('name','asc')->get();
        $task=DB::table('users')->orderBy('name','desc')->get();

        return response()->json($task);

    }
    public function select_joined()
    {
        $task=DB::table('users')
        ->join('tasks','users.id','=','tasks.user_id')
        ->select('users.name','users.email','tasks.*')
        ->get();
        return response()->json($task);
    }


}
