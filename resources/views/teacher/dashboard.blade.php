<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">শিক্ষক প্যানেল</a>
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
        <h2>স্বাগতম, {{ $teacher->user->name }}</h2>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">আমার ক্লাস</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ক্লাস</th>
                                    <th>সেকশন</th>
                                    <th>অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classTeachers as $ct)
                                    <tr>
                                        <td>{{ $ct->class->name }}</td>
                                        <td>{{ $ct->section->name }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">হাজিরা নিন</a>
                                            <a href="#" class="btn btn-sm btn-primary">মার্কস এন্ট্রি</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">কোন ক্লাস নির্ধারিত নেই</td></tr>
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
