@extends('layouts.app')

@section('content')
<section class="shop login section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Register</h2>
                    <p>Please register in order to checkout more quickly</p>
                    <!-- Form -->
                    <form class="form" method="post" action="{{route('register')}}">
                        @csrf
                        <input type="text" name="role" placeholder="" required="required" value="user" hidden>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Your Name<span>*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="" required="required" value="{{old('name')}}">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">No. Matriks<span>*</span></label>
                                    <input class="form-control" type="text" name="no_matriks" placeholder="" required="required" value="{{old('no_matriks')}}">
                                    @error('no_matriks')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Your Email<span>*</span></label>
                                    <input class="form-control" type="email" name="email" placeholder="" required="required" value="{{old('email')}}">
                                    @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Password<span>*</span></label>
                                    <input  class="form-control" type="password" name="password" placeholder="" required="required">
                                    @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password<span>*</span></label>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="" required="required">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Additional fields based on user type -->

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="facultyOffice" class="col-form-label">Faculty Office</label>
                                        <select name="facultyOffice" id="" class="form-control">
                                            <option value="">-----Select Role-----</option>
                                            @foreach($facultyOffices as $office)
                                                <option value="{{ $office->no_facultyOffice }}">{{ $office->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="course" class="col-form-label">Course</label>
                                        <select name="course" id="" class="form-control">
                                            <option value="">-----Select course-----</option>
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->no_course }}">{{ $course->name }}</option>
                                                @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Register</button>
                                    <a href="{{route('login')}}" class="btn">Login</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush
