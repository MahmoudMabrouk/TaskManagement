@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mt-3">
            <div >
                <div class="row">

                    <div class="col-md-10">

                        <form action="{{ route('employees.index') }}" method="GET">
                            <div class="d-flex mb-2">
                                <input type="text" name="search" value="{{request()->search}}" class="form-control" style="width: 200px;margin-right: 2px;">
                                <button class="btn btn-sm btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 float-lg-end">
                        <a href="{{ route('employees.create') }}" class="btn btn-primary mb-2">Add Employee</a>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Salary</th>
                            <th>Image</th>
                            <th>Manager</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ optional($employee->user)->full_name }}</td>
                                <td>{{ $employee->salary}}</td>
                                <td>
                                    @if ($employee->image)
                                        <img src="{{ asset($employee->image) }}" alt="" width="60" height="60">
                                    @endif
                                </td>
                                <td>{{ optional(optional($employee->manager)->user)->fullName}}</td>
                                <td>{{ optional($employee->department)->name}}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-info">Edit</a>
                                        <x-confirm-modal route="employees.destroy" :id="$employee->id"></x-confirm-modal>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                    <div class="text-center pb-3">
                         {{$employees->appends(request()->except('page'))->links()}}
                    </div>
                <!-- END Pagination -->
            </div>
        </div>
    </div>
@endsection
