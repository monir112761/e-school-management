<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardian Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">অভিভাবক পোর্টাল</a>
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
        <h2>স্বাগতম, {{ $guardian->user->name }}</h2>
        <p class="text-muted">সম্পর্ক: {{ $guardian->relation }}</p>

        <h4 class="mt-4">সন্তানদের তথ্য</h4>
        
        @forelse($childrenData as $data)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">{{ $data['student']->user->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>ক্লাস:</strong> {{ $data['student']->class->name }}<br>
                            <strong>সেকশন:</strong> {{ $data['student']->section->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>উপস্থিতি:</strong> {{ round($data['attendancePercentage'], 1) }}%
                        </div>
                        <div class="col-md-3">
                            <strong>বকেয়া বেতন:</strong> {{ number_format($data['pendingFees'], 2) }}
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-sm btn-primary">বিস্তারিত</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info mt-3">কোন সন্তান নিবন্ধিত নেই</div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
