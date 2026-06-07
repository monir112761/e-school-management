@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">নতুন শিক্ষার্থী তৈরি করুন</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.students.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">নাম *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">ইমেইল *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">ফোন *</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" required value="{{ old('phone') }}">
                        </div>

                        <div class="mb-3">
                            <label for="class_id" class="form-label">ক্লাস *</label>
                            <select class="form-control @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
                                <option value="">-- নির্বাচন করুন --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="section_id" class="form-label">সেকশন *</label>
                            <select class="form-control @error('section_id') is-invalid @enderror" id="section_id" name="section_id" required>
                                <option value="">-- নির্বাচন করুন --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admission_no" class="form-label">ভর্তি নং *</label>
                            <input type="text" class="form-control @error('admission_no') is-invalid @enderror" id="admission_no" name="admission_no" required value="{{ old('admission_no') }}">
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">লিঙ্গ *</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">-- নির্বাচন করুন --</option>
                                <option value="male">পুরুষ</option>
                                <option value="female">নারী</option>
                                <option value="other">অন্যান্য</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">জন্মতারিখ *</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">ঠিকানা *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">সংরক্ষণ করুন</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary w-100">বাতিল</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('class_id').addEventListener('change', async function() {
    const classId = this.value;
    const sectionSelect = document.getElementById('section_id');
    
    if (!classId) {
        sectionSelect.innerHTML = '<option value="">-- নির্বাচন করুন --</option>';
        return;
    }

    try {
        // This would typically fetch from an API endpoint
        // For now, we'll just clear the selection
        sectionSelect.innerHTML = '<option value="">লোডিং...</option>';
    } catch (error) {
        console.error('Error:', error);
    }
});
</script>
@endsection
