@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Employee</div>
                    <div class="card-body">
                        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="mb-3 col-6">
                                    <label for="department_id">Department *</label>
                                    <select name="department_id" id="department_id" class="form-control">
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{old('department_id') == $department->id ? 'selected' : ''}}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
{{--                                <div class="mb-3 col-6">--}}
{{--                                    <label for="manager_id">Manager *</label>--}}
{{--                                    <select name="manager_id" id="manager_id" class="form-control">--}}
{{--                                        <option value="" disabled selected>Select Manager</option>--}}
{{--                                        @foreach ($managers as $manager)--}}
{{--                                            <option value="{{ $manager->id }}">{{ $manager->user->fullName }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @error('manager_id')--}}
{{--                                        <p class="text-danger">{{ $message }}</p>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                                <div class="mb-3 col-6">
                                    <label for="first_name">First Name *</label>
                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="last_name">Last Name *</label>
                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="phone">Phone *</label>
                                    <input type="text" minlength="11" maxlength="13" class="form-control" placeholder="Phone" name="phone" id="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="password">Password *</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" value="{{ old('password') }}">
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="password-confirm">{{ __('Confirm Password') }} *</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="salary">Salary *</label>
                                    <input type="number" class="form-control" placeholder="Salary" name="salary" id="salary" value="{{ old('salary') }}">
                                    @error('salary')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
