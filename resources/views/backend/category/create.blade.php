@extends('backend.layouts.master')
@section('title','Category Create')
@section('main-content')

<div class="card shadow-sm border-0">
    <h5 class="card-header bg-light font-weight-bold text-primary">Add Category/h5>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.category.store') }}">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="inputName" class="font-weight-semibold">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="inputName" class="form-control" placeholder="Enter name" value="{{ old('name') }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            {{-- Buttons --}}
            <div class="form-group d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                <a href="{{ route('backend.category.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
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
