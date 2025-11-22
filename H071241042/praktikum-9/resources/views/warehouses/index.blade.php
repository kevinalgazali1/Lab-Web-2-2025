@extends('layouts.app')

@section('title', 'Warehouses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-mountain me-2"></i>Warehouses</h2>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Add New Warehouse
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><i class="fas fa-warehouse me-2"></i>All Warehouses</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>No</th>
                    <th><i class="fas fa-warehouse me-1"></i>Name</th>
                    <th><i class="fas fa-map-marker-alt me-1"></i>Location</th>
                    <th><i class="fas fa-calendar-plus me-1"></i>Created At</th>
                    <th><i class="fas fa-cogs me-1"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $warehouse)
                <tr>
                    <td>{{  $loop->iteration }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->location ?? '-' }}</td>
                    <td>{{ $warehouse->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-primary btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this warehouse?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection