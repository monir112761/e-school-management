@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>School List</h4>
        <a href="{{ route('super-admin.schools.create') }}" class="btn btn-primary">New School</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Domain</th>
                <th>Principal</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $school)
                <tr>
                    <td>{{ $school->name }}</td>
                    <td>{{ $school->domain_name }}</td>
                    <td>{{ $school->principal_name }}</td>
                    <td>{{ ucfirst($school->subscription_plan) }}</td>
                    <td>{{ $school->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('super-admin.schools.show', $school) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('super-admin.schools.destroy', $school) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this school?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $schools->links() }}
</div>
@endsection
