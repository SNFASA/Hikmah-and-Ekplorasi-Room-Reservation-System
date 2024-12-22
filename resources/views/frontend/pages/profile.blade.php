@extends('frontend.layouts.master')

@section('title','User Profile')

@section('main-content')

<div class="card shadow mb-4">
    <h4 class=" font-weight-bold" style="margin: 30px 20px 20px 30px ;">User Profile</h4>
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
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('user-profile-update', $profile->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Name</label>
                      <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$profile->name}}" class="form-control">
                      @error('name')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>
                      <div class="form-group">
                        <label for="inputnoMatriks" class="col-form-label">No MAtriks</label>
                      <input id="inputNoMatriks"  type="text" name="no_matriks" placeholder="Enter NO Matriks"  value="{{$profile->no_matriks}}" class="form-control">
                      @error('no_matriks')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
              
                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Email</label>
                        <input id="inputEmail"  type="email" name="email" placeholder="Enter email"  value="{{$profile->email}}" class="form-control">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                        <div class="form-group">
                            <label for="facultyOffice" class="col-form-label">Faculty Office</label>
                                <select name="facultyOffice" id="" class="form-control">
                                    <option value="">-----Select Role-----</option>
                                    @foreach($facultyOffices as $office)
                                        <option value="{{ $office->no_facultyOffice }}">{{ $office->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="course" class="col-form-label">Course</label>
                                <select name="course" id="" class="form-control">
                                    <option value="">-----Select course-----</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->no_course }}">{{ $course->name }}</option>
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