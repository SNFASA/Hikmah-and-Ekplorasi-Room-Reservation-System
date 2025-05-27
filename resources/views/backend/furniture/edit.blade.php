@extends('backend.layouts.master')
@section('title','Furniture Edit')
@section('main-content')

<style>
    .card.shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>

<div class="card shadow-sm border-0 mt-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Edit Furniture</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('furniture.update', $furniture->no_furniture) }}">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div class="form-group mb-3">
                <label for="inputName" class="font-weight-semibold">Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" placeholder="Enter name" value="{{ old('name', $furniture->name) }}" class="form-control">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Category --}}
            <div class="form-group mb-3">
                <label for="category" class="font-weight-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" id="category" class="form-control">
                    <option value="">----- Select Category -----</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $furniture->category) == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('category') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Status --}}
            <div class="form-group mb-3">
                <label for="status" class="font-weight-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="">----- Select Status -----</option>
                    <option value="Active" {{ old('status', $furniture->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Damage" {{ old('status', $furniture->status) == 'Damage' ? 'selected' : '' }}>Damage</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('backend.furniture.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
