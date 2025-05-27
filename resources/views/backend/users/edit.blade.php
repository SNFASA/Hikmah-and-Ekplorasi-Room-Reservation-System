@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="card shadow-sm rounded-3">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit User</h5>
    </div>

    <div class="card-body px-4 py-3">
        <form method="POST" action="{{ route('users.update', $users->id) }}">
            @csrf 
            @method('PATCH')

            <div class="grid md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="inputNoMatriks">No Matriks</label>
                    <input id="inputNoMatriks" type="text" name="no_matriks" value="{{ $users->no_matriks }}" class="form-control" placeholder="Enter No Matriks">
                    @error('no_matriks')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input id="inputName" type="text" name="name" value="{{ $users->name }}" class="form-control" placeholder="Enter Name">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input id="inputEmail" type="email" name="email" value="{{ $users->email }}" class="form-control" placeholder="Enter Email">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-- Select Role --</option>
                        <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $users->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="ppp" {{ $users->role == 'ppp' ? 'selected' : '' }}>PPP</option>
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
                            <option value="{{ $office->no_facultyOffice }}" {{ $users->facultyOffice == $office->no_facultyOffice ? 'selected' : '' }}>
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
                            <option value="{{ $course->no_course }}" {{ $users->course == $course->no_course ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Update</button>
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
