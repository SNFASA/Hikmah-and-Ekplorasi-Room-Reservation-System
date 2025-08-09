@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 ">
            <div class="page-header">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h2 class="page-title mb-1">Room Feedback Analytics</h2>
                        <p class="page-subtitle mb-0">Comprehensive insights into room performance and user satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-number">{{ count($roomStats) }}</div>
                            <div class="stats-label">Total Rooms</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-number">{{ collect($roomStats)->sum('total_feedbacks') }}</div>
                            <div class="stats-label">Total Feedbacks</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-number">{{ number_format(collect($roomStats)->avg('average_rating'), 1) }}</div>
                            <div class="stats-label">Avg Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-number">{{ collect($roomStats)->where('average_rating', '>=', 4.5)->count() }}</div>
                            <div class="stats-label">Top Rated</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Detailed Room Statistics
                </h5>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table feedback-table">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="th-content">
                                <i class="fas fa-hashtag me-1"></i>
                                Room No
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-home me-1"></i>
                                Room Name
                            </div>
                        </th>
                        <th class="text-center">
                            <div class="th-content">
                                <i class="fas fa-chart-bar me-1"></i>
                                Feedbacks
                            </div>
                        </th>
                        <th class="text-center">
                            <div class="th-content">
                                <i class="fas fa-star-half-alt me-1"></i>
                                Rating
                            </div>
                        </th>
                        <th class="text-center">
                            <div class="th-content">
                                <i class="fas fa-chart-pie me-1"></i>
                                Breakdown
                            </div>
                        </th>
                        <th class="text-center">
                            <div class="th-content">
                                <i class="fas fa-comment-alt me-1"></i>
                                Comments
                            </div>
                        </th>
                        <th class="text-center">
                            <div class="th-content">
                                <i class="fas fa-tags me-1"></i>
                                Category
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roomStats as $index => $stat)
                        <tr class="table-row" style="animation-delay: {{ $index * 0.1 }}s">
                            <td class="text-center">
                                <div class="room-number">
                                    {{ $stat['room_no'] }}
                                </div>
                            </td>
                            <td>
                                <div class="room-info">
                                    <div class="room-name">{{ $stat['room_name'] }}</div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="feedback-badge">
                                    {{ $stat['total_feedbacks'] }}
                                </span>
                            </td>
                            <td>
                                <div class="rating-container">
                                    <div class="rating-value">
                                        {{ number_format($stat['average_rating'], 1) }}/5
                                    </div>
                                    <div class="rating-progress">
                                        <div class="rating-bar" 
                                             style="width: {{ ($stat['average_rating'] / 5) * 100 }}%"
                                             data-rating="{{ $stat['average_rating'] }}">
                                        </div>
                                    </div>
                                    <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($stat['average_rating']))
                                                <i class="fas fa-star star-filled"></i>
                                            @elseif ($i <= ceil($stat['average_rating']))
                                                <i class="fas fa-star-half-alt star-half"></i>
                                            @else
                                                <i class="far fa-star star-empty"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="breakdown-container">
                                    @foreach ($stat['rating_breakdown'] as $star => $count)
                                        <div class="breakdown-item">
                                            <div class="breakdown-stars">
                                                @for ($i = 0; $i < $star; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                            </div>
                                            <div class="breakdown-count">{{ $count }}</div>
                                            <div class="breakdown-bar">
                                                <div class="breakdown-fill" 
                                                     style="width: {{ $stat['total_feedbacks'] > 0 ? ($count / $stat['total_feedbacks']) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="comment-info">
                                    <i class="fas fa-comments comment-icon"></i>
                                    <span class="comment-count">{{ $stat['comment_count'] }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="category-badge {{ strtolower($stat['top_category'] ?? 'default') }}">
                                    {{ $stat['top_category'] ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

