<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use DateTime;

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

    public function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    public function search(Request $request) {
        $title = $request->input('title', '');
        $status = $request->input('status', '');
        $to_date = $request->input('to_date',
            Carbon::now()->format('d/m/Y')
        );
        $from_date =$request->input('from_date',
            Carbon::now()->startOfWeek()->format('d/m/Y')
        );
        // $now = Carbon::now()->format('d/m/Y');
        // $weekStartDate = Carbon::now()->startOfWeek()->format('d/m/Y');
        if($status !== '' && $status !== 'Todo' && $status !== 'Done') {
            return response([
                'message' => 'Bad Request'
            ], 400);
        }

        if(!TaskApiController::validateDate($to_date) || !TaskApiController::validateDate($from_date)) {
            return response([
                'message' => 'Please provide correct timestamp and specify time in d/m/Y format'
            ], 400);
        }

        $to_date = Carbon::createFromFormat('d/m/Y', $to_date)
        ->format('Y-m-d H:i:s');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date)
        ->format('Y-m-d H:i:s');

        $user_id = auth()->user()->id;
        if($status === '') {
            $tasks = Task::where([
                ['user_id', '=', $user_id],
                ['title','LIKE','%'.$title.'%']
            ])
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();
        } else {
            $tasks = Task::where([
                ['user_id', '=', $user_id],
                ['title','LIKE','%'.$title.'%'],
                ['status', '=', $status]
            ])
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();
        }

        return response([
            'tasks' => $tasks,
            'to_date' => $to_date,
            'from_date' => $from_date
        ], 200);
    }
}

/*
    search according to due date, status, from date(default last week), to date
    pagination
    how to deploy python script on aws lambda
*/
