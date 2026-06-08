@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Create School</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('super-admin.schools.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Domain Name</label>
            <input type="text" name="domain_name" class="form-control" value="{{ old('domain_name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Principal Name</label>
            <input type="text" name="principal_name" class="form-control" value="{{ old('principal_name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subscription Plan</label>
            <select name="subscription_plan" class="form-select">
                <option value="basic">Basic</option>
                <option value="standard">Standard</option>
                <option value="premium">Premium</option>
            </select>
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Create</button>
            <a href="{{ route('super-admin.schools.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
