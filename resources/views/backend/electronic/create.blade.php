@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Electronic equpment</h5>
    <div class="card-body">
      <form method="post" action="{{route('electronic.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($categories as $key=>$cat_data)
                  <option value='Computer'>Computer</option>
                  <option value='LCD Projector'>LCD Projector</option>
              @endforeach
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
