@extends('layouts.main')

@section('title', 'Create Permission')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Create Permission')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. edit articles" required>
                        </div>

                        <div class="col-md-6">
                            <label for="guard_name" class="form-label">Guard Name</label>
                            <input type="text" class="form-control" id="guard_name" name="guard_name" value="web" placeholder="e.g. web" required>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
