@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>হাজিরা পরিচালনা</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.attendance.create') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="class_id" class="form-label">ক্লাস নির্বাচন করুন</label>
                                <select class="form-control" id="class_id" name="class_id" required>
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="section_id" class="form-label">সেকশন</label>
                                <select class="form-control" id="section_id" name="section_id" required>
                                    <option value="">-- নির্বাচন করুন --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="date" class="form-label">তারিখ</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">হাজিরা নিতে যান</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
