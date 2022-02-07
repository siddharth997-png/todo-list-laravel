@extends('layouts.app')

@section('content')
<div>
    <div class="float-start">
        <h4 class="pb-3">Create Task</h4>
    </div>
    <div class="float-end">
        <a href="{{ route('task.index') }}" class="btn btn-info">
            <i class="fa fa-arrow-left"></i> All Task
        </a>
    </div>
    <div class="clearfix"></div>
</div>

<div class="card card-body bg-light p-4">
    <form action="{{ route('task.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
            <small class='text-danger'>
                {{$errors->first('title')}}
            </small>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" class="form-control" id="description" name="description" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Todo">Todo</option>
                <option value="Done">Done</option>
            </select>
        </div>

        <a href="{{ route('task.index') }}" class="btn btn-secondary mr-2"><i class="fa fa-arrow-left"></i> Cancel</a>

        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i>
            Save
        </button>
    </form>
</div>
@endsection
