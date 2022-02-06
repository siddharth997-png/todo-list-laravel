@extends('layout')

@section('main-content')
<div>
    <div class="float-start">
        <h4 class="pb-3">Edit Task</h4>
    </div>
    <div class="float-end">
        <a href="{{ route('index') }}" class="btn btn-info">
            <i class="fa fa-arrow-left"></i> All Task
        </a>
    </div>
    <div class="clearfix"></div>
</div>

<div class="card card-body bg-light p-4">
    <form action="{{ route('task.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title"
            value="{{$task->title}}">
            <small class='text-danger' >
                {{$errors->first('title')}}
            </small>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" class="form-control" id="description" name="description" rows="2">{{$task->description}}</textarea>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Todo"
                {{$task->status === 'Todo' ? 'selected' : ''}}
                >Todo</option>
                <option value="Done"
                {{$task->status === 'Todo' ? '' : 'selected'}}
                >Done</option>
            </select>
        </div>

        <a href="{{ route('index') }}" class="btn btn-secondary mr-2"><i class="fa fa-arrow-left"></i> Cancel</a>

        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i>
            Save
        </button>
    </form>
</div>
@endsection
