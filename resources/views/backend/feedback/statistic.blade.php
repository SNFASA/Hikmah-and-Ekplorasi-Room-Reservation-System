@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="container mt-4">
    <h3 class="mb-4">📊 Room Feedback Statistics</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Room No</th>
                    <th>Name</th>
                    <th>Total Feedbacks</th>
                    <th>Average Rating</th>
                    <th>Rating Breakdown</th>
                    <th><i class="fas fa-comment-alt"></i> Comments</th>
                    <th><i class="fas fa-tags"></i> Top Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roomStats as $stat)
                    <tr>
                        <td>{{ $stat['room_no'] }}</td>
                        <td>{{ $stat['room_name'] }}</td>
                        <td><span class="badge bg-info">{{ $stat['total_feedbacks'] }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <strong class="me-2">{{ $stat['average_rating'] }}/5</strong>
                                <div class="progress w-100" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ ($stat['average_rating'] / 5) * 100 }}%;"
                                         aria-valuenow="{{ $stat['average_rating'] }}" aria-valuemin="0" aria-valuemax="5">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach ($stat['rating_breakdown'] as $star => $count)
                                <span class="text-warning">
                                    @for ($i = 0; $i < $star; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </span> : <span class="text-muted">{{ $count }}</span><br>
                            @endforeach
                        </td>
                        <td><i class="fas fa-comments text-primary"></i> {{ $stat['comment_count'] }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $stat['top_category'] }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
