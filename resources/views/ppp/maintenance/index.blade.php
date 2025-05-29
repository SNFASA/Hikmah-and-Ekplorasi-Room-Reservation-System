@extends('ppp.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<!-- Maintenance Report Card -->
<div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
    <div class="row px-3 pt-3">
        <div class="col-md-12">
            @include('ppp.layouts.notification')
        </div>
    </div>

    <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.25rem;">Maintenance Report List</h6>
        <a href="{{route('ppp.maintenance.create')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Add Report">
            <i class="fas fa-plus"></i> Add Report
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @if($maintenance->isNotEmpty())
            <table class="table table-striped table-hover table-bordered" id="post-category-dataTable" width="100%" cellspacing="0">
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
                            @php
                                $badge = 'secondary';
                                if ($report->status == 'completed') $badge = 'success';
                                elseif ($report->status == 'pending') $badge = 'warning';
                                elseif ($report->status == 'in_progress') $badge = 'info';
                                elseif ($report->status == 'rejected') $badge = 'danger';
                            @endphp
                            <span class="badge badge-{{$badge}} text-capitalize">{{ str_replace('_', ' ', $report->status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{route('ppp.maintenance.edit',$report->id)}}" 
                               class="btn btn-primary btn-sm rounded-circle mr-1 action-btn-edit" 
                               style="height:34px; width:34px;" 
                               data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{route('ppp.maintenance.destroy',[$report->id])}}" class="d-inline">
                                @csrf 
                                @method('delete')
                                <button class="btn btn-danger btn-sm rounded-circle dltBtn action-btn-delete" 
                                        data-id={{$report->id}}
                                        style="height:34px; width:34px;" 
                                        data-toggle="tooltip" title="Delete" type="button">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{$maintenance->links('pagination::bootstrap-5')}}
            </div>
            @else
                <h6 class="text-center text-muted">No maintenance reports found! Please create one.</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />

<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: none !important;
    }

    .pagination .page-link {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .page-link {
        color: #0d6efd;
    }

    .page-link:hover {
        background-color: #e2e6ea;
    }

    .action-btn-edit:hover {
        background-color: #0b5ed7 !important;
        color: #fff !important;
        box-shadow: 0 0 8px rgba(11,94,215,.7);
    }

    .action-btn-delete:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        box-shadow: 0 0 8px rgba(220,53,69,.7);
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
        .card-header a.btn {
            width: 100%;
            text-align: center;
        }
        td .btn {
            display: block;
            margin-bottom: 5px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    $('#post-category-dataTable').DataTable({
        paging: false,
        ordering: true,
        columnDefs: [{
            orderable: false,
            targets: [5]
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
