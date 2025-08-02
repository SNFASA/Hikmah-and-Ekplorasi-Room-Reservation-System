@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
    <div class="row px-3 pt-3">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>

    <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.25rem;">Category List</h6>
        <a href="{{ route('backend.category.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Add Category">
            <i class="fas fa-plus"></i> Add Type Room
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @if($categories->isNotEmpty())
            <table class="table table-striped table-hover table-bordered" id="post-category-dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot class="thead-light">
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('backend.category.edit', $category->id) }}"
                               class="btn btn-primary btn-sm rounded-circle mr-1 action-btn-edit"
                               style="height:34px; width:34px;"
                               data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        <form method="POST" action="{{ route('backend.category.destroy', $category->id) }}" class="d-inline delete-form">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger btn-sm rounded-circle action-btn-delete"
                                    style="height:34px; width:34px;"
                                    data-toggle="tooltip" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
            @else
                <h6 class="text-center text-muted">No Type room found! Please create one.</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.action-btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

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
    });
</script>
@endpush
