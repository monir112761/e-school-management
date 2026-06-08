@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-number">{{ $totalSchools }}</div>
                <div class="stat-label">সর্বমোট স্কুল</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-number">{{ $activeSchools }}</div>
                <div class="stat-label">সক্রিয় স্কুল</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-label">সর্বমোট ব্যবহারকারী</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">সর্বশেষ স্কুল</h5>
                    <a href="{{ route('super-admin.schools.create') }}" class="btn btn-sm btn-primary">নতুন স্কুল যোগ করুন</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>নাম</th>
                                <th>ডোমেইন</th>
                                <th>প্রিন্সিপাল</th>
                                <th>প্ল্যান</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSchools as $school)
                                <tr>
                                    <td>{{ $school->name }}</td>
                                    <td><code>{{ $school->domain_name }}</code></td>
                                    <td>{{ $school->principal_name }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($school->subscription_plan) }}</span></td>
                                    <td>
                                        @if($school->is_active)
                                            <span class="badge bg-success">সক্রিয়</span>
                                        @else
                                            <span class="badge bg-danger">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn btn-sm btn-outline-primary">সম্পাদনা</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">কোন স্কুল পাওয়া যায়নি</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
