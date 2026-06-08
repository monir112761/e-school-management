@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ $school->name }}</h4>
        <div>
            <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn btn-sm btn-warning">Edit</a>
            <a href="{{ route('super-admin.schools.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="list-group">
                <label class="list-group-item">
                    <input type="checkbox" class="segment-toggle" data-target="#segment-users" checked> Show Users
                </label>
                <label class="list-group-item">
                    <input type="checkbox" class="segment-toggle" data-target="#segment-students" checked> Show Students
                </label>
                <label class="list-group-item">
                    <input type="checkbox" class="segment-toggle" data-target="#segment-teachers" checked> Show Teachers
                </label>
            </div>
        </div>
        <div class="col-md-9">
            <div id="segment-users" class="card mb-3">
                <div class="card-header">Users ({{ $usersCount ?? $school->users()->count() }})</div>
                <div class="card-body"> <!-- optionally list users -->
                    <p class="text-muted">List of users will appear here.</p>
                </div>
            </div>

            <div id="segment-students" class="card mb-3">
                <div class="card-header">Students ({{ $studentsCount ?? $school->students()->count() }})</div>
                <div class="card-body">
                    <p class="text-muted">List of students will appear here.</p>
                </div>
            </div>

            <div id="segment-teachers" class="card mb-3">
                <div class="card-header">Teachers ({{ $teachersCount ?? $school->teachers()->count() }})</div>
                <div class="card-body">
                    <p class="text-muted">List of teachers will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.segment-toggle').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var target = document.querySelector(this.dataset.target);
                if (this.checked) {
                    target.style.display = '';
                } else {
                    target.style.display = 'none';
                }
            });
        });
    });
</script>

@endsection
