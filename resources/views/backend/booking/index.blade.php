@extends('backend.layouts.master')
@section('title','E-SHOP || Booking Page')
@section('main-content')

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Booking List</h6>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Booking"><i class="fas fa-plus"></i> Add Booking</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if($bookings->count() > 0)
                <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Purpose</th>
                            <th>List Student/Staff</th>
                            <th>No Room</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.N.</th>
                            <th>Purpose</th>
                            <th>List Student/Staff</th>
                            <th>No Room</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($bookings as $key => $booking)
                        @php
                            $room = DB::table('rooms')->where('no_room', $booking->no_room)->get('name');
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->purpose }}</td>
                            <td>
                                @if($booking->listStudentBookings)
                                    <ul>
                                        @foreach($booking->listStudentBookings as $student)
                                            <li>{{ $student->no_matriks }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No students found</p>
                                @endif
                            </td>
                            <td>
                             {{ $room[0]->name }}
                            </td>
                            <td>{{ $booking->booking_date }}, {{ $booking->booking_time_start }} - {{ $booking->booking_time_end }}</td>
                            <td>
                                @if($booking->status == 'approved')
                                    <span class="badge badge-success">{{ $booking->status }}</span>
                                @else
                                    <span class="badge badge-warning">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Edit" data-placement="bottom">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}">
                                    @csrf 
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $booking->id }}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>
                <span style="float:right ">{{ $bookings->links() }}</span>
            @else
                <h6 class="text-center">No bookings found! Please create a booking.</h6>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />

@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#banner-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [3, 4]
                }
            ]
        });

        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.dltBtn').click(function(e){
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
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
            });
        });
    </script>
@endpush
