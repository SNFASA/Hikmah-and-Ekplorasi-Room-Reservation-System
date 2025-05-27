@extends('backend.layouts.master')

@section('title','Admin Profile')

@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>

   <div class="card-header py-3 d-flex justify-content-between align-items-center">
     <h4 class="font-weight-bold mb-0">Profile</h4>
     <ul class="breadcrumbs mb-0">
         <li><a href="{{ route('admin') }}" class="text-muted">Dashboard</a></li>
         <li><span class="active text-primary">Profile Page</span></li>
     </ul>
   </div>

   <div class="card-body">
        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="image position-relative" style="background-image: url('{{ asset('backend/img/background.jpg') }}'); height:150px; background-position:center; background-size:cover;">
                        <img 
                            class="rounded-circle border border-white position-absolute" 
                            src="{{ asset('backend/img/avatar.png') }}" 
                            alt="profile picture"
                            style="width:80px; height:80px; top:50%; left:50%; transform: translate(-50%, 50%); object-fit: cover;">
                    </div>
                    <div class="card-body mt-5 pt-3">
                      <h5 class="card-title"><i class="fas fa-user"></i> {{ $profile->name }}</h5>
                      <p class="card-text"><i class="fas fa-id-card"></i> {{ $profile->no_matriks }}</p>
                      <p class="card-text"><i class="fas fa-envelope"></i> {{ $profile->email }}</p>
                      <p class="card-text text-muted"><i class="fas fa-user-shield"></i> {{ ucfirst($profile->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div class="col-md-8">
                <form method="POST" action="{{ route('admin-profile-update', $profile->id) }}" class="border p-4 rounded">
                    @csrf

                    <div class="form-group">
                        <label for="no_matriks" class="col-form-label">No Matriks</label>
                        <input id="no_matriks" type="text" name="no_matriks" value="{{ old('no_matriks', $profile->no_matriks) }}" class="form-control" placeholder="Enter No Matriks">
                        @error('no_matriks')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-form-label">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $profile->name) }}" class="form-control" placeholder="Enter Name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $profile->email) }}" class="form-control" placeholder="Enter Email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="col-form-label">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="">-- Select Role --</option>
                            <option value="ppp" {{ (old('role', $profile->role) == 'ppp') ? 'selected' : '' }}>PPP</option>
                            <option value="user" {{ (old('role', $profile->role) == 'user') ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ (old('role', $profile->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="facultyOffice" class="col-form-label">Faculty Office</label>
                        <select id="facultyOffice" name="facultyOffice" class="form-control">
                            <option value="">-- Select Faculty Office --</option>
                            @foreach($facultyOffices as $office)
                                <option value="{{ $office->no_facultyOffice }}" 
                                    {{ old('facultyOffice', $profile->no_facultyOffice) == $office->no_facultyOffice ? 'selected' : '' }}>
                                    {{ $office->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('facultyOffice')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </form>
            </div>
        </div>
   </div>
</div>

@endsection

@push('styles')
<style>
    .breadcrumbs {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        font-size: 14px;
    }
    .breadcrumbs li {
        margin-right: 8px;
    }
    .breadcrumbs li a {
        color: #999;
        text-decoration: none;
    }
    .breadcrumbs li a:hover {
        text-decoration: underline;
    }
    .breadcrumbs li .active {
        color: #007bff;
        font-weight: 600;
        cursor: default;
    }
    .breadcrumbs li + li:before {
        content: "/";
        margin-right: 8px;
        color: #999;
    }
</style>
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush
