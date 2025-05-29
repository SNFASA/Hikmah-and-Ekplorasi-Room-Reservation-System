@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system|| All Notifications')
@section('main-content')
<!-- Notifications Card -->
<div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.25rem;">Notifications</h6>
    </div>
    <div class="card-body">
        @if(count(Auth::user()->Notifications) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="notification-dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Time</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Auth::user()->Notifications as $notification)
                        <tr class="@if($notification->unread()) bg-light border-left-light @else border-left-success @endif">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $notification->created_at->format('F d, Y h:i A') }}</td>
                            <td>{{ $notification->data['title'] }}</td>
                            <td class="text-center">
                                <a href="{{ route('notification.detail', $notification->id) }}" 
                                   class="btn btn-primary btn-sm rounded-circle mr-1 action-btn-edit" 
                                   style="height: 34px; width: 34px;" 
                                   data-toggle="tooltip" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('notification.delete', $notification->id) }}" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm rounded-circle dltBtn action-btn-delete" 
                                            data-id="{{ $notification->id }}" 
                                            style="height: 34px; width: 34px;" 
                                            data-toggle="tooltip" title="Delete" type="button">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-2x text-muted mb-3"></i>
                <h6 class="text-muted">No new notifications!</h6>
            </div>
        @endif
    </div>
</div>
@endsection
@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

@endpush
@push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
    $(document).ready(function() {
        $('#notification-dataTable').DataTable({
            "order": [[1, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 3] }
            ]
        });
    });

    $('.dltBtn').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this notification!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
  <script>
@endpush
@push('styles')
<style>
    .action-btn-edit:hover {
        background-color: #0b5ed7 !important;
        color: #fff !important;
        box-shadow: 0 0 8px rgba(11, 94, 215, 0.7);
    }

    .action-btn-delete:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.7);
    }

    .tooltip-inner {
        font-size: 0.875rem;
    }

    @media (max-width: 575.98px) {
        .card-header h6 {
            margin-bottom: 0.5rem;
            text-align: center;
            width: 100%;
        }
        td .btn {
            display: block;
            margin-bottom: 5px;
        }
    }
</style>

@endpush
