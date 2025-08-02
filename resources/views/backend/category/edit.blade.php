@extends('backend.layouts.master')
@section('title','Category Edit')
@section('main-content')

<style>
    .card.shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>

<div class="card shadow-sm border-0 mt-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Edit Category</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.category.update', $categories->id) }}">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="form-group mb-3">
                <label for="inputName" class="font-weight-semibold">Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" placeholder="Enter name" value="{{ old('name', $categories->name) }}" class="form-control">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            {{-- Action Buttons --}}
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('backend.category.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
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
