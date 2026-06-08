<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Support\Str;

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

// Create class
$base = time();
$class = SchoolClass::create([
    'school_id' => $school->id,
    'name' => 'Grade '.($base%100),
    'numeric_value' => 'G'.$base,
]);
if ($class) {
    echo "Created class id={$class->id} name={$class->name}\n";
} else {
    echo "Failed to create class\n";
    exit(1);
}

// Update
$class->update(['name' => $class->name.' (updated)']);
echo "Updated class id={$class->id} name={$class->name}\n";

// Delete
$id = $class->id;
$class->delete();
$trashed = SchoolClass::withTrashed()->find($id);
if ($trashed && $trashed->deleted_at) {
    echo "Verified class soft-deleted id={$id}\n";
} else {
    echo "Class delete verification failed for id={$id}\n";
}

