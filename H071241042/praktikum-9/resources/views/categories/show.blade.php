@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-tag me-2"></i>Category: {{ $category->name }}</h3>
                <div class="d-flex gap-1">
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%"><i class="fas fa-hashtag me-1"></i>ID</th>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-tag me-1"></i>Name</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-file-alt me-1"></i>Description</th>
                        <td>{{ $category->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar-plus me-1"></i>Created At</th>
                        <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar-check me-1"></i>Updated At</th>
                        <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection