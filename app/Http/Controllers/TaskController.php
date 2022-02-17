<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $tasks = $user->tasks->sortByDesc('id');
        $data = compact('tasks');
        return view('index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required'
        ]);
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->user_id = auth()->user()->id;
        $task->save();
        return redirect('/task');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $task = Task::find($id);
        if(is_null($task)) {
            return redirect('/task');
        }
        $user_id = auth()->user()->id;
        if($user_id !== $task->user_id) {
            return redirect('/task');
        }

        return view('edit')->with(compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if(is_null($task)) {
            return redirect('/task');
        }
        $request->validate([
            'title' => 'required'
        ]);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return redirect('/task');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $task = Task::find($id);
        if(is_null($task)) {
            return redirect('/task');
        }
        $user_id = auth()->user()->id;
        if($user_id !== $task->user_id) {
            return redirect('/task');
        }
        $task->delete();
        return redirect('/task');
    }

    public function search() {
        $title = $_GET['title'];
        $user_id = auth()->user()->id;
        $tasks = Task::where([
            ['user_id', '=', $user_id],
            ['title','LIKE','%'.$title.'%']
        ])->get();
        $data = compact('tasks');
        return view('index')->with($data);
    }
}
