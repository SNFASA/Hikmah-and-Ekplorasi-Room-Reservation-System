@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}">
        @csrf()
        <div class="form-group">
          <label for="inputno_matriks" class="col-form-label">No matriks</label>
        <input id="inputno_matriks" type="text" name="no_matriks" placeholder="Enter no matriks"  value="{{old('no_matriks')}}" class="form-control">
        @error('no_matriks')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputname" class="col-form-label">Name</label>
        <input id="inputname" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{old('email')}}" autocomplete="new-email" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        @php
          $roles = DB::table('users')->select('role')->get();
          $facultyOffices = DB::table('faculty_Offices')->select('no_facultyOffice', 'name')->get();
          $courses = DB::table('courses')->select('no_course', 'name')->get();
        @endphp
    
        <div class="form-group">
          <label for="role" class="col-form-label">Role</label>
          <select name="role" class="form-control">
            <option value="">-----Select Role-----</option>
            <option value="admin">Admin</option>
            <option value="student">Student</option>
            <option value="staff">Staff</option>
          </select>
          @error('role')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="facultyOffice" class="col-form-label">Faculty Office</label>
            <select name="facultyOffice" class="form-control">
              <option value="">-----Select Faculty Office-----</option>
                @foreach($facultyOffices as $office)
              <option value="{{ $office->no_facultyOffice }}">{{ $office->name }}</option>
                @endforeach
            </select>
          @error('facultyOffice')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
    
        <div class="form-group">
          <label for="course" class="col-form-label">Course</label>
            <select name="course" class="form-control">
              <option value="">-----Select Course-----</option>
                @foreach($courses as $course)
              <option value="{{ $course->no_course }}">{{ $course->name }}</option>
                @endforeach
            </select>
            @error('course')
              <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{old('password')}}"  autocomplete="new-password" class="form-control">
            @error('password')
              <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
          <label for="inputPasswordConfirmation" class="col-form-label">Confirm Password</label>
          <input id="inputPasswordConfirmation" type="password" name="password_confirmation" placeholder="Confirm password" autocomplete="new-password" class="form-control">
          @error('password_confirmation')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button class="btn btn-success" type="submit">Submit</button>
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