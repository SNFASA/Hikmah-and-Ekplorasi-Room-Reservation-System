@extends('ppp.layouts.master')
@section('title','LibraRoom Reservation system ')
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($rooms)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Name</th>
              <th>Capacity</th>
              <th>Type Room</th>
              <th>Furniture</th>
              <th>Electronic equpment</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Name</th>
              <th>Capacity</th>
              <th>Type Room</th>
              <th>Furniture</th>
              <th>Electronic equpment</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($rooms as $room)
            <tr>
                <td>{{ $room->no_room }}</td>
                <td>{{ $room->name }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ $room->type_room }}</td>
                <td>
                    @if($room->furnitures->isNotEmpty())
                        {{ $room->furnitures->pluck('name')->join(', ') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($room->electronics->isNotEmpty())
                        {{ $room->electronics->pluck('name')->join(', ') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($room->status == 'valid')
                        <span class="badge badge-success">{{ $room->status }}</span>
                    @else
                        <span class="badge badge-warning">{{ $room->status }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('ppp.room.edit', $room->no_room) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        
        </table>
        <span style="float:right">{{$rooms->links()}}</span>
        @else
          <h6 class="text-center">No Room found!!! Please create Room</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
