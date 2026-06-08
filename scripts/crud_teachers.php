<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

use App\Models\School;
use App\Models\Teacher;
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

// Create user for teacher
$user = User::create([
    'school_id' => $school->id,
    'name' => 'Teacher User '.time(),
    'email' => 'teacher'.time().'@example.com',
    'password' => Hash::make('password'),
    'phone' => '018'.(rand(10000000,99999999)),
    'role' => 'teacher',
    'is_active' => true,
]);

// Create teacher
$teacher = Teacher::create([
    'school_id' => $school->id,
    'user_id' => $user->id,
    'employee_no' => 'EMP'.(time()%10000),
    'qualification' => 'MSc',
    'specialization' => 'Mathematics',
    'joining_date' => date('Y-m-d'),
    'salary' => 25000.00,
    'bank_account_no' => '0123456789',
    'bank_name' => 'Local Bank',
    'is_active' => true,
]);
if ($teacher) {
    echo "Created teacher id={$teacher->id}\n";
} else {
    echo "Failed to create teacher\n";
    exit(1);
}

// Update
$teacher->update(['is_active' => false]);
echo "Updated teacher id={$teacher->id} is_active={$teacher->is_active}\n";

// Delete
$id = $teacher->id;
$teacher->delete();
$trashed = Teacher::withTrashed()->find($id);
if ($trashed && $trashed->deleted_at) {
    echo "Verified teacher soft-deleted id={$id}\n";
} else {
    echo "Teacher delete verification failed for id={$id}\n";
}
