@extends('layouts.app')

@section('content')

<nav class="navbar navbar-light bg-light justify-content-between">
    <h4 class="pb-3">My Tasks</h4>
    <div class="d-flex flex-row">
        <a href="{{route('task.create')}}" class="btn btn-success mx-4">
            <i class="fa fa-plus-circle"></i> Create Task
        </a>
        <form class="form-inline d-flex flex-row" method="GET" action="search">
            <input class="form-control mr-sm-2 mx-1" type="search" placeholder="Search Title" aria-label="Search" name="title">
            <button class="btn btn-outline-success my-2 my-sm-0 mx-1" type="submit">Search</button>
        </form>
    </div>


  </nav>

@foreach ($tasks as $task)
    <div class="card mt-3">
        <h5 class="card-header">
        {{$task->title}}
            <span class="badge rounded-pill bg-success text-light">
                Created At : {{$task->created_at->diffForHumans()}}
            </span>
        </h5>

        <div class="card-body">
            <div class="card-text">
                <div class="float-start">
                    {{$task->description}}
                    <br>

                    <span class="badge rounded-pill bg-{{
                    $task->status === 'Todo' ? 'warning' : 'success'
                    }} text-{{
                    $task->status === 'Todo' ? 'dark' : 'light'
                    }}">
                        {{$task->status}}
                    </span>

                    <br>
                    <small>Last Updated -
                        <span class="badge rounded-pill bg-success text-light">
                            {{$task->updated_at->diffForHumans()}}
                        </span>
                    </small>
                </div>
                <div class="float-end">
                    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-success">
                    <i class="fa fa-edit">Edit</i>
                    </a>

                    <form action="{{ route('task.destroy', $task->id)}}" style="display: inline" method="POST" onsubmit="return confirm('Are you sure to delete ?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash">Delete</i>
                        </button>
                    </form>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endforeach
@if (count($tasks) === 0)
    <div class="alert alert-info p-2">
        No Task Found. Click on Create Task button to create a task.
    </div>
@endif
@endsection
