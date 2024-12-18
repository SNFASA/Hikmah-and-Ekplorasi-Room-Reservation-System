@extends('ppp.layouts.master')
@section('title','Electronic Create')
@section('main-content')

<div class="card">
    <h5 class="card-header">Add Electronic equpment</h5>
    <div class="card-body">
      <form method="post" action="{{route('ppp.electronic.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputName" class="col-form-label">Name</label>
          <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="category">Category <span class="text-danger">*</span></label>
          <select name="category" id="category" class="form-control">
            <option value="">-----Select Category-----</option>
            <option value="computer">Computer</option>
            <option value="LCD Projector">LCD Projector</option>
          </select>
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" class="form-control">
              <option value="Active">Active</option>
              <option value="Damage">Damage</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
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
