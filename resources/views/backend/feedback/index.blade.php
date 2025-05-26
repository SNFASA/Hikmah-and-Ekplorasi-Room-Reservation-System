@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Feedback Lists</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @if($feedbacks->isNotEmpty())
            <table class="table table-bordered table-striped table-hover" id="post-category-dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>S.N.</th>
                        <th>Booking No</th>
                        <th>User</th>
                        <th>Rating ⭐</th>
                        <th>Category 🗂️</th>
                        <th>Comment 💬</th>
                    </tr>
                </thead>
                <tfoot class="thead-light">
                    <tr>
                        <th>S.N.</th>
                        <th>Booking No</th>
                        <th>User</th>
                        <th>Rating ⭐</th>
                        <th>Category 🗂️</th>
                        <th>Comment 💬</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($feedbacks as $feedback)
                    <tr>
                        <td>{{ $feedback->id }}</td>
                        <td>{{ $feedback->booking->id ?? 'N/A' }}</td>
                        <td>{{ $feedback->user->no_matriks ?? 'Unknown' }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}">★</span>
                            @endfor
                        </td>
                        <td>{{ $feedback->category }}</td>
                        <td>{{ $feedback->comment }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {!! $feedbacks->links() !!}
            </div>
            @else
            <h6 class="text-center">No Feedback found!</h6>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    table th,
    table td {
        vertical-align: middle !important;
        font-size: 0.9rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right;
    }

    .text-warning {
        color: #ffc107 !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $('#post-category-dataTable').DataTable({
        columnDefs: [
            { orderable: false, targets: [3, 4, 5] }
        ],
        paging: false,
        info: false,
        searching: false
    });
</script>
@endpush
