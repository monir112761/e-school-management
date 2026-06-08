@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Edit School</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('super-admin.schools.update', $school) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $school->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $school->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $school->phone) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $school->address) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subscription Plan</label>
            <select name="subscription_plan" class="form-select">
                <option value="basic" {{ $school->subscription_plan=='basic'?'selected':'' }}>Basic</option>
                <option value="standard" {{ $school->subscription_plan=='standard'?'selected':'' }}>Standard</option>
                <option value="premium" {{ $school->subscription_plan=='premium'?'selected':'' }}>Premium</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Active</label>
            <input type="checkbox" name="is_active" value="1" {{ $school->is_active ? 'checked' : '' }}>
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Update</button>
            <a href="{{ route('super-admin.schools.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
