@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="container mt-4">
    <h3 class="mb-4">📊 Room Feedback Statistics</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-light text-center">
                <tr>
                    <th>🏷️ Room No</th>
                    <th>🏠 Name</th>
                    <th><i class="fas fa-chart-bar"></i> Total Feedbacks</th>
                    <th><i class="fas fa-star-half-alt"></i> Avg Rating</th>
                    <th>⭐ Breakdown</th>
                    <th><i class="fas fa-comment-alt"></i> Comments</th>
                    <th><i class="fas fa-tags"></i> Top Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roomStats as $stat)
                    <tr>
                        <td class="text-center">{{ $stat['room_no'] }}</td>
                        <td>{{ $stat['room_name'] }}</td>
                        <td class="text-center">
                            <span class="badge bg-info rounded-pill">{{ $stat['total_feedbacks'] }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <strong class="me-2 text-dark">{{ number_format($stat['average_rating'], 1) }}/5</strong>
                                <div class="progress w-100" style="height: 10px;">
                                    <div class="progress-bar bg-success"
                                         role="progressbar"
                                         style="width: {{ ($stat['average_rating'] / 5) * 100 }}%;"
                                         aria-valuenow="{{ $stat['average_rating'] }}"
                                         aria-valuemin="0" aria-valuemax="5">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach ($stat['rating_breakdown'] as $star => $count)
                                <span class="text-warning d-inline-block" style="width: 70px;">
                                    @for ($i = 0; $i < $star; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </span>
                                <span class="text-muted">{{ $count }}</span><br>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <i class="fas fa-comments text-primary"></i>
                            <span class="ms-1">{{ $stat['comment_count'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $stat['top_category'] ?? 'N/A' }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    table th,
    table td {
        vertical-align: middle !important;
        font-size: 0.9rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4em 0.6em;
    }

    .progress {
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }
</style>
@endpush
