<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - স্কুল ম্যানেজমেন্ট</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card { padding: 20px; border-radius: 10px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-number { font-size: 2rem; font-weight: bold; color: #667eea; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">📚 {{ auth()->user()->school->name ?? 'স্কুল' }}</a>
            <div class="ms-auto">
                <span class="text-white me-3">স্বাগতম, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-5">
        <h2 class="mb-4">ড্যাশবোর্ড</h2>
        
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalStudents }}</div>
                    <div class="text-muted">মোট শিক্ষার্থী</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalTeachers }}</div>
                    <div class="text-muted">মোট শিক্ষক</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $presentToday }}</div>
                    <div class="text-muted">আজ উপস্থিত</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ number_format($totalFeeCollected, 0) }}</div>
                    <div class="text-muted">এই মাসের বেতন</div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">দ্রুত লিঙ্ক</div>
                    <div class="card-body">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-primary me-2">শিক্ষার্থী ব্যবস্থাপনা</a>
                        <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary me-2">হাজিরা</a>
                        <a href="#" class="btn btn-primary me-2">পরীক্ষা</a>
                        <a href="#" class="btn btn-primary">ফি ম্যানেজমেন্ট</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
