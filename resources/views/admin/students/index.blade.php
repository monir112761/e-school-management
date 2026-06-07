@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>শিক্ষার্থী পরিচালনা</h2>
                <a href="{{ route('admin.students.create') }}" class="btn btn-primary">নতুন শিক্ষার্থী যোগ করুন</a>
            </div>

            @if($students->count())
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>নাম</th>
                                    <th>ইমেইল</th>
                                    <th>ক্লাস</th>
                                    <th>সেকশন</th>
                                    <th>ভর্তি নং</th>
                                    <th>রোল নং</th>
                                    <th>অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>{{ $student->class->name }}</td>
                                        <td>{{ $student->section->name }}</td>
                                        <td><code>{{ $student->admission_no }}</code></td>
                                        <td>{{ $student->roll_no }}</td>
                                        <td>
                                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-primary">সম্পাদনা</a>
                                            <form method="POST" action="{{ route('admin.students.destroy', $student) }}" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $students->links() }}
                </div>
            @else
                <div class="alert alert-info">কোন শিক্ষার্থী পাওয়া যায়নি</div>
            @endif
        </div>
    </div>
</div>
@endsection
