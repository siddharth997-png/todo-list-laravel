<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;

class TaskApiController extends Controller
{
    public function fetchAllTasks() {
        return response(Task::all(), 200);
    }

    public function index() {
        $user_id = auth()->user()->id;
        $tasks = Task::where([
            ['user_id', '=', $user_id]
        ])->get();
        return response($tasks, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'status' => 'in:Todo,Done'
        ]);
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->user_id = $user = auth()->user()->id;
        $task->save();
        return $task;
    }

    public function show($task_id) {
        $task = Task::find($task_id);
        if(!$task) {
            return response([
                'message' => 'Data not found'
            ], 404);
        } else if($task->user_id !==  auth()->user()->id) {
            return response([
                'message' => 'Task does not belong to you'
            ], 403);
        }
        return response($task, 200);
    }

    public function update(Request $request, $task_id) {

        $task = Task::find($task_id);
        if(!$task) {
            return response([
                'message' => 'Data not found'
            ], 404);
        } else if($task->user_id !==  auth()->user()->id) {
            return response([
                'message' => 'Task does not belong to you'
            ], 403);
        }

        $request->validate([
            'title' => 'required',
            'status' => 'in:Todo,Done'
        ]);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return response($task,200);
    }

    public function destroy($id) {
        $task = Task::find($id);
        if(!$task) {
            return response([
                'message' => 'Data not found'
            ], 404);
        } else if($task->user_id !==  auth()->user()->id) {
            return response([
                'message' => 'Task does not belong to you'
            ], 403);
        }
        $task->delete();
        return response([
            'message' => 'Task Deleted Successfully'
        ], 200);
    }

    public function search($title) {
        $user_id = auth()->user()->id;
        $tasks = Task::where([
            ['user_id', '=', $user_id],
            ['title','LIKE','%'.$title.'%']
        ])->get();
        return response($tasks, 200);
    }



}
