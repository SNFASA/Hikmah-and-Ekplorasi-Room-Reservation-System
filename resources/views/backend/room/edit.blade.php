@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Room</h5>
    <div class="card-body">
      <form method="post" action="{{route('room.update',$room->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Room name<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$room->name}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        {{-- {{$parent_cats}} --}}
        {{-- {{$category}} --}}
        <div class="form-group {{(($room->is_parent==1) ? 'd-none' : '')}}" id='parent_cat_div'>
          <label for="parent_id">Fruniture</label>
          <select name="parent_id" class="form-control">
              <option value="">--Select any Fruniture--</option>
              @foreach($parent_cats as $key=>$parent_cat)
              
                  <option value='{{$parent_cat->id}}' {{(($parent_cat->id==$room->parent_id) ? 'selected' : '')}}>{{$parent_cat->name}}</option>
              @endforeach
          </select>
        </div>
      <div class="form-group {{(($room->is_parent==1) ? 'd-none' : '')}}" id='parent_cat_div'>
          <label for="parent_id">Electronic equpment</label>
          <select name="parent_id" class="form-control">
              <option value="">--Select any equpment--</option>
              @foreach($parent_cats as $key=>$parent_cat)
              
                  <option value='{{$parent_cat->id}}' {{(($parent_cat->id==$room->parent_id) ? 'selected' : '')}}>{{$parent_cat->name}}</option>
              @endforeach
          </select>
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="valid" {{(($room->status=='valid')? 'selected' : '')}}>valid</option>
              <option value="invalid" {{(($room->status=='invalid')? 'selected' : '')}}>invalid</option>
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

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
<script>
  $('#is_parent').change(function(){
    var is_checked=$('#is_parent').prop('checked');
    // alert(is_checked);
    if(is_checked){
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    }
    else{
      $('#parent_cat_div').removeClass('d-none');
    }
  })
</script>
@endpush