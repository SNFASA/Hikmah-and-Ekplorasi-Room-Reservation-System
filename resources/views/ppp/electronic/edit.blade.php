@extends('ppp.layouts.master')
@section('title','Electronic Edit')
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
    <h5 class="card-header bg-light font-weight-bold text-primary">Edit Electronic Equipment</h5>
    <div class="card-body">
        <form method="post" action="{{route('ppp.electronic.update',$electronics->no_electronicEquipment)}}">
            @csrf 
            @method('PUT')

            {{-- Name --}}
            <div class="form-group mb-3">
                <label for="inputTitle" class="font-weight-semibold">Name <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{ old('name', $electronics->name) }}" class="form-control">
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            @php
                // Preserving the original database queries
                $categories = DB::table('electronic_equipment')->select('category')->where('no_electronicEquipment', $electronics->no_electronicEquipment)->get();
                $status = DB::table('electronic_equipment')->select('status')->where('no_electronicEquipment', $electronics->no_electronicEquipment)->get();
            @endphp

            {{-- Category --}}
            <div class="form-group mb-3">
                <label for="category" class="font-weight-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-control">
                    <option value="">----- Select Category -----</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category }}" {{ $category->category == 'Computer' ? 'selected' : '' }}>Computer</option>
                        <option value="{{$category->category}}" {{ $category->category == 'LCD Projector' ? 'selected' : '' }}>LCD Projector</option>
                    @endforeach
                </select>
                @error('category')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group mb-3">
                <label for="status" class="font-weight-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="">----- Select Status -----</option>
                    <option value="Active" {{(($electronics->status=='active') ? 'selected' : '')}}>Active</option>
                    <option value="Damage" {{(($electronics->status=='Damage') ? 'selected' : '')}}>Damage</option>
                </select>
                @error('status')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ URL::previous() }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button class="btn btn-success text-white shadow-sm w-100 w-sm-auto" type="submit">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection