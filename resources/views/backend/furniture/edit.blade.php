@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Furniture</h5>
    <div class="card-body">
      <form method="post" action="{{route('furniture.update',$furnitures->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$furnitures->title}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($furnitures as $key=>$cat_data)
                  <option value='{{$cat_data->id}}' {{(($furnitures->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->name}}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" class="form-control">
            <option value="Active" {{(($furnitures->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="Damage" {{(($furnitures->status=='Damage') ? 'selected' : '')}}>Damage</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection
