@extends('backend.layouts.master')
@section('title','Furniture Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Furniture</h5>
    <div class="card-body">
      <form method="post" action="{{route('furniture.update',$furniture->no_furniture)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputName" class="col-form-label">Name</label>
          <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{$furniture->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="category">Category <span class="text-danger">*</span></label>
          <select name="category" id="category" class="form-control">
              <option value="">-----Select Category-----</option>
              @foreach($categories as $category)
                  <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                      {{ $category }}
                  </option>
              @endforeach
          </select>
      </div>
      
        <div class="form-group">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" class="form-control">
            <option value="Active" {{(($furniture->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="Damage" {{(($furniture->status=='Damage') ? 'selected' : '')}}>Damage</option>
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
