@extends('layouts.main')

@section('title', 'Edit Permission')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Permission')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="guard_name" class="form-label">Guard Name</label>
                            <input type="text" class="form-control" id="guard_name" name="guard_name" value="{{ $permission->guard_name }}" required>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
