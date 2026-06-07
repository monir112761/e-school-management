<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - স্কুল ম্যানেজমেন্ট সিস্টেম</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar { background: #2c3e50; color: white; min-height: 100vh; }
        .card { border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card { padding: 20px; text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: bold; color: #667eea; }
        .stat-label { color: #7f8c8d; font-size: 0.9rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">📚 স্কুল ম্যানেজমেন্ট সিস্টেম</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-5">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
