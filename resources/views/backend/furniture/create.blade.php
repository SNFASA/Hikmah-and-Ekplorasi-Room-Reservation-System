@extends('backend.layouts.master')
@section('title','Furniture Create')
@section('main-content')

<div class="card shadow-sm border-0">
    <h5 class="card-header bg-light font-weight-bold text-primary">Add Furniture</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('furniture.store') }}">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="inputName" class="font-weight-semibold">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="inputName" class="form-control" placeholder="Enter name" value="{{ old('name') }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Category --}}
            <div class="form-group">
                <label for="category" class="font-weight-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" id="category" class="form-control">
                    <option value="">----- Select Category -----</option>
                    <option value="Desk" {{ old('category') == 'Desk' ? 'selected' : '' }}>Desk</option>
                    <option value="Chair" {{ old('category') == 'Chair' ? 'selected' : '' }}>Chair</option>
                    <option value="Japanese desk" {{ old('category') == 'Japanese desk' ? 'selected' : '' }}>Japanese desk</option>
                    <option value="Whiteboard" {{ old('category') == 'Whiteboard' ? 'selected' : '' }}>Whiteboard</option>
                </select>
                @error('category') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="status" class="font-weight-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Damage" {{ old('status') == 'Damage' ? 'selected' : '' }}>Damage</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Buttons --}}
            <div class="form-group d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                <a href="{{ route('furniture.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white w-100 w-sm-auto shadow-sm transition">
                    <i class="fas fa-check mr-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
