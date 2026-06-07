<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">শিক্ষার্থী পোর্টাল</a>
            <div class="ms-auto">
                <span class="text-white me-3">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">বেরিয়ে যান</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>স্বাগতম, {{ $student->user->name }}</h2>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>ক্লাস</h5>
                        <p class="text-primary fs-4">{{ $student->class->name }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>সেকশন</h5>
                        <p class="text-primary fs-4">{{ $student->section->name }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>উপস্থিতি</h5>
                        <p class="text-primary fs-4">{{ round($attendancePercentage, 1) }}%</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>রোল নম্বর</h5>
                        <p class="text-primary fs-4">{{ $student->roll_no ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ক্লাস রুটিন</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>সময়</th>
                                        <th>বিষয়</th>
                                        <th>শিক্ষক</th>
                                        <th>রুম</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classRoutines as $day => $routines)
                                        @forelse($routines as $routine)
                                            <tr>
                                                <td>{{ $routine->start_time }} - {{ $routine->end_time }}</td>
                                                <td>{{ $routine->subject->name }}</td>
                                                <td>{{ $routine->teacher->user->name }}</td>
                                                <td>{{ $routine->room_no ?? 'N/A' }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted">কোন রুটিন পাওয়া যায়নি</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
