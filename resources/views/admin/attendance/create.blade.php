@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4">
                <h2>{{ $class->name }} - {{ $section->name }} - হাজিরা</h2>
                <p class="text-muted">তারিখ: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.attendance.store') }}">
                @csrf

                <input type="hidden" name="class_id" value="{{ $class->id }}">
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                <input type="hidden" name="attendance_date" value="{{ $date }}">

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>রোল</th>
                                    <th>নাম</th>
                                    <th>স্ট্যাটাস</th>
                                    <th>মন্তব্য</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    @php
                                        $att = $existingAttendance->get($student->id);
                                    @endphp
                                    <tr>
                                        <td>{{ $student->roll_no }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>
                                            <select class="form-select form-select-sm" name="attendance[{{ $loop->index }}][student_id]" style="display:none;">
                                                <option value="{{ $student->id }}"></option>
                                            </select>
                                            <input type="hidden" name="attendance[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                            <select class="form-select form-select-sm" name="attendance[{{ $loop->index }}][status]">
                                                <option value="present" {{ ($att->status ?? 'present') === 'present' ? 'selected' : '' }}>উপস্থিত</option>
                                                <option value="absent" {{ ($att->status ?? null) === 'absent' ? 'selected' : '' }}>অনুপস্থিত</option>
                                                <option value="leave" {{ ($att->status ?? null) === 'leave' ? 'selected' : '' }}>ছুটি</option>
                                                <option value="late" {{ ($att->status ?? null) === 'late' ? 'selected' : '' }}>দেরি</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="attendance[{{ $loop->index }}][remarks]" value="{{ $att->remarks ?? '' }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">বাতিল</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
