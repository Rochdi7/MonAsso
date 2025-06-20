@extends('layouts.main')

@section('title', 'Meeting Details')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Meeting Documents')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Meeting Details</h5>
                <a href="{{ route('admin.meetings.index') }}" class="btn btn-sm btn-outline-dark">← Back to List</a>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>{{ $meeting->title }}</h5>
                    <p class="mb-1"><strong>Organizer:</strong> {{ $meeting->organizer->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($meeting->datetime)->format('Y-m-d H:i') }}</p>
                    <p class="mb-3">
                        <strong>Status:</strong>
                        @if($meeting->status === 1)
                            <span class="badge bg-light-success text-success">✔ Confirmed</span>
                        @elseif($meeting->status === 2)
                            <span class="badge bg-light-danger text-danger">✖ Cancelled</span>
                        @else
                            <span class="badge bg-light-warning text-warning">⏳ Pending</span>
                        @endif
                    </p>
                </div>

                <hr>

                <h6>Attached Documents</h6>
                @if($documents->isEmpty())
                    <p class="text-muted">No documents found for this meeting.</p>
                @else
                    <ul class="list-group">
                        @foreach($documents as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    📎 {{ $doc->file_name }}
                                </span>
                                <a href="{{ route('media.custom', ['id' => $doc->id, 'filename' => rawurlencode($doc->file_name)]) }}"
                                   class="btn btn-sm btn-primary" target="_blank">
                                    View / Download
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
