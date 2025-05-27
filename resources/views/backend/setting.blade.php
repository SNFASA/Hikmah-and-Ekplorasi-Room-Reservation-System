@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="card">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Edit Setting</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('settings.update') }}">
            @csrf
            {{-- @method('PATCH') --}}

            <div class="form-group">
                <label for="quote" class="col-form-label">Short Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="quote" name="short_des">{{ old('short_des', $data->short_des ?? '') }}</textarea>
                @error('short_des')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $data->description ?? '') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail1" class="col-form-label">Logo <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-prepend">
                        <button id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary" type="button">
                            <i class="fa fa-picture-o"></i> Choose
                        </button>
                    </span>
                    <input id="thumbnail1" class="form-control" type="text" name="logo" value="{{ old('logo', $data->logo ?? '') }}">
                </div>
                <div id="holder1" style="margin-top:15px;max-height:100px;">
                    @if(!empty($data->logo))
                        <img src="{{ $data->logo }}" style="height: 80px;">
                    @endif
                </div>
                @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail" class="col-form-label">Photo <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-prepend">
                        <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" type="button">
                            <i class="fa fa-picture-o"></i> Choose
                        </button>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ old('photo', $data->photo ?? '') }}">
                </div>
                <div id="holder" style="margin-top:15px;max-height:100px;">
                    @if(!empty($data->photo))
                        <img src="{{ $data->photo }}" style="height: 80px;">
                    @endif
                </div>
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
                <input id="address" type="text" class="form-control" name="address" required value="{{ old('address', $data->address ?? '') }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control" name="email" required value="{{ old('email', $data->email ?? '') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                <input id="phone" type="text" class="form-control" name="phone" required value="{{ old('phone', $data->phone ?? '') }}">
                @error('phone')
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

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  // File manager buttons
  $('#lfm').filemanager('image');
  $('#lfm1').filemanager('image');

  // Initialize summernote editors once
  $(document).ready(function() {
    $('#quote').summernote({
      placeholder: "Write short description.....",
      tabsize: 2,
      height: 100
    });

    $('#description').summernote({
      placeholder: "Write detailed description.....",
      tabsize: 2,
      height: 150
    });
  });
</script>
@endpush
