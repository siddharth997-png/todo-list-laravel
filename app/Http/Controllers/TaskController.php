<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tasks = Task::orderBy('id','desc')->get();
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
        echo '<pre>';
        print_r($request->all());
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            return redirect('/');
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
            return redirect('/');
        }
        $request->validate([
            'title' => 'required'
        ]);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return redirect('/');

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
            return redirect('/');
        }
        $task->delete();
        return redirect('/');
    }
}
