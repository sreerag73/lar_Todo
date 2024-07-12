<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
class TaskController extends Controller
{
    public function add_task(Request $request)
    {
        $request->validate([
        'title'=>'required|string',
        'discription'=>'required|string',
        'date'=>'required|date',
        'user_id'=>'required',
        ]);

        $user=$request->user();
        Task::create([
            'user_id'=>$user->id,
            'title'=>$request->title,
            'discription'=>$request->discription,
            'date'=>$request->date,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'task created successfully',
        ],200);
    }
}
