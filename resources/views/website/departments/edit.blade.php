@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit "{{ $department->name }}" Department</div>
                    <div class="card-body">
                        <form action="{{ route('departments.update', $department->id ) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name">Department Name</label>
                                <input type="text" class="form-control" placeholder="Department Name..." name="name" id="name" value="{{ $department->name }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
               
            </div>
        </div>    
    </div>    
@endsection