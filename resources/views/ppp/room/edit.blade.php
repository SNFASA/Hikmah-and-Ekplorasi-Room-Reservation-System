@extends('ppp.layouts.master')
@section('title','Room Edit')
@section('main-content')

<div class="card shadow-sm border-0">
    <h5 class="card-header bg-light font-weight-bold text-primary">Update Room</h5>
    <div class="card-body">
        <form method="post" action="{{ route('ppp.room.update', $room->no_room) }}">
            @csrf
            @method('PUT')     

            <!-- Room Name -->
            <div class="form-group">
                <label for="inputName" class="font-weight-semibold">Room Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" value="{{ old('name', $room->name) }}" class="form-control" readonly>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Capacity -->
            <div class="form-group">
                <label for="capacity" class="font-weight-semibold">Capacity <span class="text-danger">*</span></label>
                <input id="capacity" type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" class="form-control" readonly>
                @error('capacity')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Furniture Selection -->
            <div class="form-group">
                <label for="furniture-select" class="font-weight-semibold">Furniture <span class="text-danger">*</span></label>
                <select id="furniture-select" class="form-control">
                    <option value="">--Select Furniture--</option>
                    @foreach($furnitures as $furniture)
                        @if(!in_array($furniture->no_furniture, $selectedFurnitures->pluck('no_furniture')->toArray()))
                            <option value="{{ $furniture->no_furniture }}">{{ $furniture->name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('furniture')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Selected Furniture -->
            <div class="form-group">
                <label for="selected-furniture" class="font-weight-semibold">Selected Furniture</label>
                <ul id="selected-furniture" class="list-group mb-3">
                    @foreach($selectedFurnitures as $selectedFurniture)
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="{{ $selectedFurniture->no_furniture }}">
                            {{ $selectedFurniture->name }}
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $selectedFurniture->no_furniture }}" data-type="furniture">&times;</button>
                        </li>
                        <input type="hidden" name="furniture[]" value="{{ $selectedFurniture->no_furniture }}">
                    @endforeach
                </ul>
            </div>
            <div id="furniture-hidden-inputs"></div>
            <button type="button" id="add-selected-furniture" class="btn btn-primary mb-4 shadow-sm transition w-100 w-sm-auto">
                <i class="fas fa-plus mr-1"></i> Add Selected Furniture
            </button>

            <!-- Electronic Equipment Selection -->
            <div class="form-group">
                <label for="electronic-equipment-select" class="font-weight-semibold">Electronic Equipment <span class="text-danger">*</span></label>
                <select id="electronic-equipment-select" class="form-control">
                    <option value="">--Select Equipment--</option>
                    @foreach($electronics as $electronic)
                        @if(!in_array($electronic->no_electronicEquipment, $selectedElectronics->pluck('no_electronicEquipment')->toArray()))
                            <option value="{{ $electronic->no_electronicEquipment }}">{{ $electronic->name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('electronicEquipment')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Selected Electronics -->
            <div class="form-group">
                <label for="selected-electronics" class="font-weight-semibold">Selected Electronics</label>
                <ul id="selected-electronics" class="list-group mb-3">
                    @foreach($selectedElectronics as $selectedElectronic)
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}">
                            {{ $selectedElectronic->name }}
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}" data-type="electronics">&times;</button>
                        </li>
                        <input type="hidden" name="electronicEquipment[]" value="{{ $selectedElectronic->no_electronicEquipment }}">
                    @endforeach
                </ul>
            </div>
            <div id="electronics-hidden-inputs"></div>
            <button type="button" id="add-selected-equipment" class="btn btn-primary mb-4 shadow-sm transition w-100 w-sm-auto">
                <i class="fas fa-plus mr-1"></i> Add Selected Equipment
            </button>

            <!-- Room Type -->
            <div class="form-group">
                <label for="type_room" class="font-weight-semibold">Type Room <span class="text-danger">*</span></label>
                <select name="type_room" class="form-control" readonly>
                    <option value="HIKMAH" {{ $room->type_room == 'HIKMAH' ? 'selected' : '' }}>HIKMAH</option>
                    <option value="EKSPLORASI" {{ $room->type_room == 'EKSPLORASI' ? 'selected' : '' }}>EKSPLORASI</option>
                </select>
                @error('type_room')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="form-group d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('ppp.room.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-save mr-1"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#add-selected-furniture').click(function () {
        const selectedItemId = $('#furniture-select').val();
        const selectedItemText = $('#furniture-select option:selected').text();

        if (selectedItemId) {
            if (!$(`#selected-furniture li[data-item-id="${selectedItemId}"]`).length) {
                $('#selected-furniture').append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="${selectedItemId}">
                        ${selectedItemText}
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${selectedItemId}" data-type="furniture">&times;</button>
                    </li>
                `);
                $('#furniture-hidden-inputs').append(`<input type="hidden" name="furniture[]" value="${selectedItemId}">`);
                $(`#furniture-select option[value="${selectedItemId}"]`).remove();
            }
        }
    });

    $('#add-selected-equipment').click(function () {
        const selectedItemId = $('#electronic-equipment-select').val();
        const selectedItemText = $('#electronic-equipment-select option:selected').text();

        if (selectedItemId) {
            if (!$(`#selected-electronics li[data-item-id="${selectedItemId}"]`).length) {
                $('#selected-electronics').append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="${selectedItemId}">
                        ${selectedItemText}
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${selectedItemId}" data-type="electronics">&times;</button>
                    </li>
                `);
                $('#electronics-hidden-inputs').append(`<input type="hidden" name="electronicEquipment[]" value="${selectedItemId}">`);
                $(`#electronic-equipment-select option[value="${selectedItemId}"]`).remove();
            }
        }
    });

    $(document).on('click', '.remove-item', function () {
        const itemId = $(this).data('item-id');
        const itemType = $(this).data('type');
        const itemText = $(this).closest('li').text().trim().replace('×', '').trim();

        $(this).closest('li').remove();
        $(`input[name="${itemType}[]"][value="${itemId}"]`).remove();

        if (itemType === 'furniture') {
            $('#furniture-select').append(`<option value="${itemId}">${itemText}</option>`);
        } else if (itemType === 'electronics') {
            $('#electronic-equipment-select').append(`<option value="${itemId}">${itemText}</option>`);
        }
    });
});
</script>
@endpush
