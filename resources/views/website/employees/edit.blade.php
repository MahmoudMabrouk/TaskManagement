@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Edit "{{ $employee->user->fullName }}" Employee</div>
                    <div class="card-body">
                        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">


                                <div class="mb-3 col-6">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="form-control">
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" @selected($employee->department_id == $department->id )>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" value="{{ $employee->user->first_name }}">
                                    @error('first_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" value="{{ $employee->user->last_name }}">
                                    @error('last_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="{{ $employee->user->email }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" minlength="11" maxlength="13" class="form-control" placeholder="Phone" name="phone" id="phone" value="{{ $employee->user->phone }}">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="salary">Salary</label>
                                    <input type="number" class="form-control" placeholder="Salary" name="salary" id="salary" value="{{ $employee->salary }}">
                                    @error('salary')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    @if ($employee->image)
                                        <img src="{{ asset( $employee->image )}}" alt="" width="120" height="120">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 ">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
