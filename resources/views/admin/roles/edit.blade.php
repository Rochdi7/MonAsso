@extends('layouts.main')

@section('title', 'Edit Role')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Role')

@section('css')
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter role name" value="{{ $role->name }}" required />
                        </div>

                        <div class="col-12">
                            <h5 class="mt-4">Assign Permissions</h5>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection

@section('scripts')
@endsection
