@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system')
@section('main-content')

<div class="card shadow-sm rounded-3">
    <div class="card-header bg-light font-weight-bold text-primary">
        <h5 class="mb-0">Add New User</h5>
    </div>

    <div class="card-body px-4 py-3">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="inputno_matriks">No Matriks</label>
                    <input type="text" name="no_matriks" id="inputno_matriks" class="form-control" placeholder="Enter No Matriks" value="{{ old('no_matriks') }}">
                    @error('no_matriks')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputname">Name</label>
                    <input type="text" name="name" id="inputname" class="form-control" placeholder="Enter Name" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                        @php
                          $roles = DB::table('users')->select('role')->get();
                          $facultyOffices = DB::table('faculty_Offices')->select('no_facultyOffice', 'name')->get();
                          $courses = DB::table('courses')->select('no_course', 'name')->get();
                        @endphp

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-- Select Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="ppp" {{ old('role') == 'ppp' ? 'selected' : '' }}>PPP</option>
                    </select>
                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="facultyOffice">Faculty Office</label>
                    <select name="facultyOffice" class="form-control">
                        <option value="">-- Select Faculty Office --</option>
                        @foreach($facultyOffices as $office)
                            <option value="{{ $office->no_facultyOffice }}" {{ old('facultyOffice') == $office->no_facultyOffice ? 'selected' : '' }}>
                                {{ $office->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('facultyOffice')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="course">Course</label>
                    <select name="course" class="form-control">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->no_course }}" {{ old('course') == $course->no_course ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Enter Password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPasswordConfirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="inputPasswordConfirmation" class="form-control" placeholder="Confirm Password">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-check mr-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush
