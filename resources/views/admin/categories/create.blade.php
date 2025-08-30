@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Category</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Category Information</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Category Examples:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>HR:</strong> Human Resources related complaints</li>
                                <li><strong>IT:</strong> Information Technology issues</li>
                                <li><strong>Finance:</strong> Financial and accounting matters</li>
                                <li><strong>Facilities:</strong> Building and maintenance issues</li>
                                <li><strong>General:</strong> Other general complaints</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
