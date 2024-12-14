@extends('ppp.layouts.master')
@section('title','LibraRoom Reservation system ')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Furniture</h5>
    <div class="card-body">
      <form method="post" action="{{route('ppp.electronic.update',$electronics->no_electronicEquipment)}}">
        @csrf 
        @method('PUT')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$electronics->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        @php
        // Fetching roles, faculty offices, and courses data from the database
        $categories = DB::table('electronic_equipment')->select('category')->where('no_electronicEquipment', $electronics->no_electronicEquipment)->get();
        $status = DB::table('electronic_equipment')->select('status')->where('no_electronicEquipment', $electronics->no_electronicEquipment)->get();
      @endphp

      <div class="form-group">
        <label for="category" class="col-form-label">Category</label>
        <select name="category" class="form-control">
            <option value="">-----Select Category-----</option>
              @foreach($categories as $category)
                <option value="{{ $category->category }}" {{ $category->category == 'Computer' ? 'selected' : '' }}>Computer</option>
                <option value="{{$category ->category }}" {{ $category->category == 'LCD Projector' ? 'selected' : '' }}>LCD Projector</option>
              @endforeach
        </select>
          @error('category')
          <span class="text-danger">{{ $message }}</span>
         @enderror
      </div>
      <div class="form-group">
        <label for="status" class="col-form-label">Status</label>
        <select name="status" class="form-control">
            <option value="">-----Select Status-----</option>
            <option value="Active" {{(($electronics->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="Damage" {{(($electronics->status=='Damage') ? 'selected' : '')}}>Damage</option>
        </select>
          @error('status')
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
