@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system ')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$users->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
            <label for="inputTitle" class="col-form-label">No matriks</label>
          <input id="inputTitle" type="text" name="no_matriks" placeholder="Enter no matriks"  value="{{$users->no_matriks}}" class="form-control">
          @error('no_matriks')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$users->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{$users->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{--<div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{$users->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}
        @php
          // Fetching roles, faculty offices, and courses data from the database
          $roles = DB::table('users')->select('role')->where('id', $users->id)->get();
          $facultyOffices = DB::table('faculty_Offices')->select('no_facultyOffice', 'name')->get();
          $courses = DB::table('courses')->select('no_course', 'name')->get();
        @endphp
    
    <div class="form-group">
        <label for="role" class="col-form-label">Role</label>
        <select name="role" class="form-control">
            <option value="">-----Select Role-----</option>
            @foreach($roles as $role)
                <option value="{{ $role->role }}" {{ $role->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="{{ $role->role }}" {{ $role->role == 'student' ? 'selected' : '' }}>Student</option>
                <option value="{{ $role->role }}" {{ $role->role == 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="{{ $role->role }}" {{ $role->role == 'ppp' ? 'selected' : '' }}>PPP</option>

            @endforeach
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
    
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
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