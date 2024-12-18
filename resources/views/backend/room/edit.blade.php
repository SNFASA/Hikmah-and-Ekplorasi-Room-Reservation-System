@extends('backend.layouts.master')
@section('title','Room Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Update Room</h5>
    <div class="card-body">
        <form method="post" action="{{ route('room.update', $room->no_room) }}">
          @csrf
          @method('PATCH') 
            <!-- Room Name -->
            <div class="form-group">
                <label for="inputName" class="col-form-label">Room Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" placeholder="Enter name" value="{{$room->name}}" class="form-control">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Capacity -->
            <div class="form-group">
                <label for="capacity">Capacity <span class="text-danger">*</span></label>
                <input id="capacity" type="number" name="capacity" min="0" placeholder="Enter capacity" value="{{$room->capacity}}" class="form-control">
                @error('capacity')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Furniture Selection -->
            <div class="form-group">
              <label for="furniture">Furniture <span class="text-danger">*</span></label>
              <select id="furniture-select" class="form-control">
                <option value="">--Select Furniture--</option>
                  @foreach($furnitures as $furniture)
                    @if(!in_array($furniture->no_furniture, $selectedFurnitures->pluck('no_furniture')->toArray()))
                      <option value="{{ $furniture->no_furniture }}">{{ $furniture->name }}</option>
                    @endif
                  @endforeach
              </select>
                  @error('furniture')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <!-- Selected Furniture -->
              <div class="form-group">
                <label for="selected-furniture">Selected Furniture</label>
                <ul id="selected-furniture" class="list-group">
                  @foreach($selectedFurnitures as $selectedFurniture)
                    <li class="list-group-item d-flex justify-content-between" data-item-id="{{ $selectedFurniture->no_furniture }}">
                      {{ $selectedFurniture->name }}
                      <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $selectedFurniture->no_furniture }}" data-type="furniture">Remove</button>
                    </li>
                    <input type="hidden" name="furniture[]" value="{{ $selectedFurniture->no_furniture }}">
                  @endforeach
                </ul>
              </div>
              <div id="furniture-hidden-inputs"></div>
                <button type="button" id="add-selected-furniture" class="btn btn-primary">Add Selected Furniture</button>
              <!-- Electronic Equipment Selection -->
              <div class="form-group">
                  <label for="electronicEquipment">Electronic Equipment <span class="text-danger">*</span></label>
                    <select id="electronic-equipment-select" class="form-control">
                      <option value="">--Select Equipment--</option>
                          @foreach($electronics as $electronic)
                              @if(!in_array($electronic->no_electronicEquipment, $selectedElectronics->pluck('no_electronicEquipment')->toArray()))
                                  <option value="{{ $electronic->no_electronicEquipment }}">{{ $electronic->name }}</option>
                              @endif
                          @endforeach
                    </select>
                    @error('electronicEquipment')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
              </div>
              <!-- Selected Electronics -->
              <div class="form-group">
                <label for="selected-electronics">Selected Electronics</label>
                  <ul id="selected-electronics" class="list-group">
                    @foreach($selectedElectronics as $selectedElectronic)
                    <li class="list-group-item d-flex justify-content-between" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}">
                      {{ $selectedElectronic->name }}
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}" data-type="electronics">Remove</button>
                    </li>
                    <input type="hidden" name="electronicEquipment[]" value="{{ $selectedElectronic->no_electronicEquipment }}">
                    @endforeach
                  </ul>
              </div>
              <div id="electronics-hidden-inputs"></div>
              <button type="button" id="add-selected-equipment" class="btn btn-primary">Add Selected Equipment</button>
            <!-- Room Type -->
            <div class="form-group">
                <label for="type_room" class="col-form-label">Type Room<span class="text-danger">*</span></label>
                <select name="type_room" class="form-control">
                    <option value="HIKMAH">HIKMAH</option>
                    <option value="EKSPLORASI">EKSPLORASI</option>
                </select>
                @error('type_room')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="valid">Valid</option>
                    <option value="invalid">Invalid</option>
                </select>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <div class="form-group mb-3">
              <button class="btn btn-success" type="submit">Update</button>
          </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Add selected furniture
    $('#add-selected-furniture').click(function () {
        const selectedItemId = $('#furniture-select').val();
        const selectedItemText = $('#furniture-select option:selected').text();

        if (selectedItemId) {
            if (!$(`#selected-furniture li[data-item-id="${selectedItemId}"]`).length) {
                $('#selected-furniture').append(`
                    <li class="list-group-item d-flex justify-content-between" data-item-id="${selectedItemId}">
                        ${selectedItemText}
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${selectedItemId}" data-type="furniture">Remove</button>
                    </li>
                `);
                $('#furniture-hidden-inputs').append(`<input type="hidden" name="furniture[]" value="${selectedItemId}">`);
                $(`#furniture-select option[value="${selectedItemId}"]`).remove();
            }
        }
    });

    // Add selected electronic equipment
    $('#add-selected-equipment').click(function () {
        const selectedItemId = $('#electronic-equipment-select').val();
        const selectedItemText = $('#electronic-equipment-select option:selected').text();

        if (selectedItemId) {
            if (!$(`#selected-electronics li[data-item-id="${selectedItemId}"]`).length) {
                $('#selected-electronics').append(`
                    <li class="list-group-item d-flex justify-content-between" data-item-id="${selectedItemId}">
                        ${selectedItemText}
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${selectedItemId}" data-type="electronics">Remove</button>
                    </li>
                `);
                $('#electronics-hidden-inputs').append(`<input type="hidden" name="electronicEquipment[]" value="${selectedItemId}">`);
                $(`#electronic-equipment-select option[value="${selectedItemId}"]`).remove();
            }
        }
    });

    // Remove item from the list
    $(document).on('click', '.remove-item', function () {
        const itemId = $(this).data('item-id');
        const itemType = $(this).data('type');
        const itemText = $(this).closest('li').text().trim().replace('Remove', '').trim();

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
