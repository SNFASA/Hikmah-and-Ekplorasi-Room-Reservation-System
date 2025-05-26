@extends('backend.layouts.master')
@section('title','Electronic Create')
@section('main-content')

<style>
    /* Hover effect on card */
    .card.shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
    /* Button group spacing */
    .form-group.mb-3 > button {
        min-width: 100px;
    }
</style>

<div class="card shadow mt-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Add Electronic Equipment</h5>
    <div class="card-body">
      <form method="post" action="{{ route('backend.electronic.store') }}">
        @csrf
        <div class="form-group mb-3">
          <label for="inputName" class="col-form-label">Name</label>
          <input id="inputName" type="text" name="name" placeholder="Enter name" value="{{ old('name') }}" class="form-control">
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <label for="category">Category <span class="text-danger">*</span></label>
          <select name="category" id="category" class="form-control">
            <option value="">-----Select Category-----</option>
            <option value="computer" {{ old('category') == 'computer' ? 'selected' : '' }}>Computer</option>
            <option value="LCD Projector" {{ old('category') == 'LCD Projector' ? 'selected' : '' }}>LCD Projector</option>
          </select>
          @error('category')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" id="status" class="form-control">
            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Damage" {{ old('status') == 'Damage' ? 'selected' : '' }}>Damage</option>
          </select>
          @error('status')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group mb-3 d-flex gap-2 flex-column flex-sm-row justify-content-end">
                <a href="{{ route('backend.electronic.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
          <button type="submit" class="btn btn-success shadow-sm w-100 w-sm-auto">
            <i class="fas fa-check me-1"></i> Submit
          </button>
        </div>
      </form>
    </div>
</div>

@endsection
