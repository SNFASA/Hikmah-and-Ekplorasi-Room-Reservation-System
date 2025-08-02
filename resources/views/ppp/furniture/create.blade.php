@extends('ppp.layouts.master')
@section('title','Furniture Create')
@section('main-content')

<style>
    .card.shadow-sm:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
    .form-group.mb-3 > button {
        min-width: 100px;
    }
    .text-danger {
        color: #dc3545 !important;
    }
</style>

<div class="card shadow-sm border-0 mt-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Add Furniture</h5>
    <div class="card-body">
        <form method="post" action="{{route('ppp.furniture.store')}}">
            @csrf

            {{-- Name --}}
            <div class="form-group mb-3">
                <label for="inputName" class="font-weight-semibold">Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" placeholder="Enter name" value="{{old('name')}}" class="form-control">
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            {{-- Category --}}
            <div class="form-group mb-3">
                <label for="category" class="font-weight-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if(old('category_id', $electronics->category_id ?? '') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group mb-3">
                <label for="status" class="font-weight-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Damage" {{ old('status') == 'Damage' ? 'selected' : '' }}>Damage</option>
                </select>
                @error('status')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ URL::previous() }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-check me-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection