@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="container-fluid px-3 pt-3">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Report">
            <i class="fas fa-plus"></i> Add User
        </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if(count($users) > 0)
                <table class="table table-striped table-hover" id="user-dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>No Matriks</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Faculty/Department</th>
                            <th>Course</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)  
                        @php
                            $faculty = DB::table('faculty_offices')->where('no_facultyOffice', $user->facultyOffice)->value('name'); 
                            $course = DB::table('courses')->where('no_course', $user->course)->value('name');
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->no_matriks }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $faculty }}</td>
                            <td>{{ $course }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                    @csrf 
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger dltBtn" data-id="{{ $user->id }}" style="border-radius: 50%;" data-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                @else
                    <h6 class="text-center text-muted">No User found! Please create a user.</h6>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    table.dataTable tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3rem 0.6rem;
        margin: 2px;
        background-color: #e2e8f0;
        border-radius: 5px;
        font-size: 0.875rem;
        border: none;
        color: #333;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #3182ce;
        color: white !important;
    }

    .btn-sm {
        padding: 5px 9px;
        font-size: 0.75rem;
    }

    .table td, .table th {
        vertical-align: middle;
    }
</style>
@endpush
@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

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
