@extends('backend.layouts.master')

@section('title','Admin Profile')

@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
   <div class="card-header py-3">
     <h4 class=" font-weight-bold">Profile</h4>
     <ul class="breadcrumbs">
         <li><a href="{{route('admin')}}" style="color:#999">Dashboard</a></li>
         <li><a href="" class="active text-primary">Profile Page</a></li>
     </ul>
   </div>
   <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="image">
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                    </div>
                    <div class="card-body mt-4 ml-2">
                      <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$profile->name}}</small></h5>
                      <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$profile->no_matriks}}</small></p>
                      <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$profile->email}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i> {{$profile->role}}</small></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-8">
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('admin-profile-update',$profile->id)}}">
                    @csrf
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">No matriks</label>
                      <input id="inputTitle" type="text" name="no_matriks" placeholder="Enter no matriks"  value="{{$profile->no_matriks}}" class="form-control">
                      @error('no_matriks')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Name</label>
                      <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$profile->name}}" class="form-control">
                      @error('name')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input id="email" type="email" name="email" placeholder="Enter email" value="{{ $profile->email }}" class="form-control">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                      <div class="form-group">
                          <label for="role" class="col-form-label">Role</label>
                          <select name="role" class="form-control">
                              <option value="">-----Select Role-----</option>
                                  <option value="ppp" {{(($profile->role=='ppp')? 'selected' : '')}}>PPP</option>
                                  <option value="user" {{(($profile->role=='user')? 'selected' : '')}}>User</option>
                                  <option value="admin" {{(($profile->role=='admin')? 'selected' : '')}}>Admin</option>

                          </select>
                            @error('role')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="facultyOffice" class="col-form-label">Faculty Office</label>
                                <select name="facultyOffice" id="" class="form-control">
                                    <option value="">-----Select Role-----</option>
                                    @foreach($facultyOffices as $office)
                                        <option value="{{ $office->no_facultyOffice }}" 
                                            @if($profile->no_facultyOffice == $office->no_facultyOffice) selected @endif>
                                            {{ $office->name }}
                                        </option>
                                     @endforeach
                                </select>

                        </div>
                        <div class="form-group">
                            <label for="course" class="col-form-label">Course</label>
                                <select name="course" id="" class="form-control">
                                    <option value="">-----Select course-----</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->no_course }}" 
                                            @if($profile->no_course == $course->no_course) selected @endif>
                                            {{ $course->name }}
                                        </option>
                                     @endforeach
                                    </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
   </div>
</div>

@endsection

<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset('backend/img/background.jpg')}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style> 

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush