<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

echo "Running crud_students.php\n";

use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

// Ensure a school exists
$school = School::first();
if (!$school) {
    $school = School::create([
        'name' => 'Auto School '.time(),
        'slug' => Str::slug('Auto School '.time()),
        'domain_name' => 'autoschool'.time().'.local',
        'email' => 'auto'.time().'@example.com',
        'phone' => '0123456789',
        'address' => 'Auto Address',
        'city' => 'Dhaka',
        'state' => 'Dhaka',
        'postal_code' => '1207',
        'country' => 'Bangladesh',
        'principal_name' => 'Auto Principal',
        'principal_email' => 'auto-principal'.time().'@example.com',
        'principal_phone' => '01900000000',
        'subscription_plan' => 'basic',
        'subscription_start_date' => date('Y-m-d'),
        'subscription_end_date' => date('Y-m-d', strtotime('+1 year')),
    ]);
    echo "Created school id={$school->id}\n";
}

// Ensure a class exists
$class = SchoolClass::where('school_id', $school->id)->first();
if (!$class) {
    $class = SchoolClass::create([
        'school_id' => $school->id,
        'name' => 'Auto Grade '.(time()%100),
        'numeric_value' => 'G'.(time()%100),
    ]);
    echo "Created class id={$class->id}\n";
}

// Ensure a section exists for the class
$section = Section::where('class_id', $class->id)->first();
if (!$section) {
    $section = Section::create([
        'school_id' => $school->id,
        'class_id' => $class->id,
        'name' => 'A',
        'capacity' => 50,
        'is_active' => true,
    ]);
    echo "Created section id={$section->id}\n";
}

// Create a user for the student (users.user_id is NOT NULL)
$user = User::create([
    'school_id' => $school->id,
    'name' => 'Student User '.time(),
    'email' => 'student'.time().'@example.com',
    'password' => Hash::make('password'),
    'phone' => '017'.(rand(10000000,99999999)),
    'role' => 'student',
    'is_active' => true,
]);

// Create student
$student = Student::create([
    'school_id' => $school->id,
    'user_id' => $user->id,
    'class_id' => $class->id,
    'section_id' => $section->id,
    'admission_no' => 'ADM'.(time()%10000),
    'roll_no' => time()%1000,
    'admission_date' => date('Y-m-d'),
    'blood_group' => 'A+',
    'nationality' => 'Bangladeshi',
    'religion' => 'Islam',
    'medical_history' => null,
    'is_active' => true,
]);
if ($student) {
    echo "Created student id={$student->id}\n";
} else {
    echo "Failed to create student\n";
    exit(1);
}

// Update
$student->update(['is_active' => false]);
echo "Updated student id={$student->id} is_active={$student->is_active}\n";

// Delete
$id = $student->id;
$student->delete();
$trashed = Student::withTrashed()->find($id);
if ($trashed && $trashed->deleted_at) {
    echo "Verified student soft-deleted id={$id}\n";
} else {
    echo "Student delete verification failed for id={$id}\n";
}
