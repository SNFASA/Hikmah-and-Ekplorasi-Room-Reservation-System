@extends('backend.layouts.master')
@section('title','Room Create')
@section('main-content')

<div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
    <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.25rem;">Add Room</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('room.store') }}">
            @csrf

            <!-- Room Name -->
            <div class="form-group mb-3">
                <label for="inputName">Room Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}">
                @error('name')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Capacity -->
            <div class="form-group mb-3">
                <label for="capacity">Capacity <span class="text-danger">*</span></label>
                <input id="capacity" type="number" min="0" name="capacity" class="form-control" placeholder="Enter capacity" value="{{ old('capacity') }}">
                @error('capacity')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Furniture -->
            <div class="form-group mb-3">
                <label>Furniture <span class="text-danger">*</span></label>
                <div class="d-flex gap-2 flex-wrap">
                    <select id="furniture-select" class="form-control">
                        <option value="">--Select Furniture--</option>
                        @foreach($furnitures as $furniture)
                            <option value="{{ $furniture->no_furniture }}">{{ $furniture->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="add-selected-furniture" class="btn btn-primary btn-sm rounded">Add</button>
                </div>
                @error('furniture')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
                <ul id="selected-furniture" class="list-group mt-2"></ul>
                <div id="furniture-hidden-inputs"></div>
            </div>

            <!-- Electronics -->
            <div class="form-group mb-3">
                <label>Electronic Equipment <span class="text-danger">*</span></label>
                <div class="d-flex gap-2 flex-wrap">
                    <select id="electronic-equipment-select" class="form-control">
                        <option value="">--Select Equipment--</option>
                        @foreach($electronics as $electronic)
                            <option value="{{ $electronic->no_electronicEquipment }}">{{ $electronic->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="add-selected-equipment" class="btn btn-primary btn-sm rounded">Add</button>
                </div>
                @error('electronicEquipment')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
                <ul id="selected-electronics" class="list-group mt-2"></ul>
                <div id="electronics-hidden-inputs"></div>
            </div>

            <!-- Room Type -->
            <div class="form-group mb-3">
                <label for="type_room">Type Room <span class="text-danger">*</span></label>
                <select name="type_room" class="form-control">
                    <option value="HIKMAH">HIKMAH</option>
                    <option value="EKSPLORASI">EKSPLORASI</option>
                </select>
                @error('type_room')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group mb-4">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="valid">Valid</option>
                    <option value="invalid">Invalid</option>
                </select>
                @error('status')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('backend.room.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
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

@push('scripts')
<script>
$(document).ready(function () {
    function addSelectedItem(selectId, listId, hiddenContainerId, inputName, type) {
        const selectedItemId = $(`#${selectId}`).val();
        const selectedItemText = $(`#${selectId} option:selected`).text();

        if (selectedItemId && !$(`#${listId} li[data-item-id="${selectedItemId}"]`).length) {
            $(`#${listId}`).append(`
                <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="${selectedItemId}">
                    ${selectedItemText}
                    <button type="button" class="btn btn-danger btn-sm rounded-circle remove-item" data-item-id="${selectedItemId}" data-type="${type}" style="width: 28px; height: 28px;">
                        <i class="fas fa-times"></i>
                    </button>
                </li>
            `);
            $(`#${hiddenContainerId}`).append(`<input type="hidden" name="${inputName}[]" value="${selectedItemId}">`);
            $(`#${selectId} option[value="${selectedItemId}"]`).remove();
        }
    }

    $('#add-selected-furniture').click(() => {
        addSelectedItem('furniture-select', 'selected-furniture', 'furniture-hidden-inputs', 'furniture', 'furniture');
    });

    $('#add-selected-equipment').click(() => {
        addSelectedItem('electronic-equipment-select', 'selected-electronics', 'electronics-hidden-inputs', 'electronicEquipment', 'electronics');
    });

    $(document).on('click', '.remove-item', function () {
        const itemId = $(this).data('item-id');
        const type = $(this).data('type');
        const itemText = $(this).closest('li').contents().get(0).nodeValue.trim();

        $(this).closest('li').remove();
        $(`input[name="${type}[]"][value="${itemId}"]`).remove();
        const selectId = type === 'furniture' ? '#furniture-select' : '#electronic-equipment-select';
        $(selectId).append(`<option value="${itemId}">${itemText}</option>`);
    });
});
</script>
@endpush
