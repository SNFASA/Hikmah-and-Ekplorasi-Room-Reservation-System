@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system ')
@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Maintenance Report List</h6>
        <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Report">
            <i class="fas fa-plus"></i> Add Report
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @if($maintenance->isNotEmpty())
                <table class="table table-bordered table-hover table-striped" id="post-category-dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($maintenance as $report)   
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->title }}</td>
                                <td>{{ $report->itemType }}</td>
                                <td>{{ $report->itemName }}</td>
                                <td>
                                    @if($report->status == 'completed')
                                        <span class="badge badge-success">{{ $report->status }}</span>
                                    @elseif($report->status == 'pending')
                                        <span class="badge badge-warning">{{ $report->status }}</span>
                                    @elseif($report->status == 'in_progress')
                                        <span class="badge badge-info">{{ $report->status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $report->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('maintenance.edit', $report->id) }}" class="btn btn-primary btn-sm mr-1" style="height:30px; width:30px; border-radius:50%;" data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('maintenance.destroy', $report->id) }}" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $report->id }}" style="height:30px; width:30px; border-radius:50%;" data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>  
                        @endforeach
                    </tbody>
                </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $maintenance->links('pagination::bootstrap-5') }}
            </div>
            @else
                <h6 class="text-center">No maintenance report found! Please create a report.</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: none;
    }
    .table th, .table td {
        vertical-align: middle !important;
    }
</style>
@endpush

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Init DataTable -->
<script>
$(document).ready(function() {
    $('#post-category-dataTable').DataTable({
        paging: false,
        ordering: true,
        columnDefs: [{
            orderable: false,
            targets: [4]
        }],
        searching: true,
        info: false,
        autoWidth: false
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
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
