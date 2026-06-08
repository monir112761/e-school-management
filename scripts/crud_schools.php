<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap console kernel for facades
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Login as super-admin (assumed ID 1)
Auth::loginUsingId(1);

// Prepare data
$base = time();
$data = [
    'name' => 'Test School '.$base,
    'domain_name' => 'testschool'.$base.'.local',
    'email' => 'testschool'.$base.'@example.com',
    'phone' => '0123456789',
    'address' => '123 Test St',
    'city' => 'Dhaka',
    'state' => 'Dhaka',
    'postal_code' => '1207',
    'country' => 'Bangladesh',
    'principal_name' => 'Principal Test',
    'principal_email' => 'principal'.$base.'@example.com',
    'principal_phone' => '01987654321',
    'subscription_plan' => 'basic',
    'subscription_start_date' => date('Y-m-d'),
    'subscription_end_date' => date('Y-m-d', strtotime('+1 year')),
];

$data['slug'] = Str::slug($data['name']);

$school = School::create($data);
if (!$school) {
    echo "Create failed\n";
    exit(1);
}

echo "Created school id={$school->id} name={$school->name}\n";

// Verify via internal request to index
$http = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/super-admin/schools', 'GET');
$response = $http->handle($request);
$content = (string) $response->getContent();
if (strpos($content, $school->name) !== false) {
    echo "Verified presence on index after create\n";
} else {
    echo "Verification failed: name not found on index after create\n";
}

// Update
$school->update(['name' => $school->name.' (updated)', 'subscription_plan' => 'standard']);
echo "Updated school id={$school->id} name={$school->name}\n";

// Verify update
$request = Illuminate\Http\Request::create('/super-admin/schools', 'GET');
$response = $http->handle($request);
$content = (string) $response->getContent();
if (strpos($content, $school->name) !== false) {
    echo "Verified updated name on index\n";
} else {
    echo "Verification failed: updated name not found on index\n";
}

// Delete
$schoolId = $school->id;
$school->delete();
echo "Deleted school id={$schoolId}\n";

// Verify deletion in DB (soft delete)
$trashed = School::withTrashed()->find($schoolId);
if ($trashed && $trashed->deleted_at !== null) {
    echo "Verified deletion (soft deleted) in DB\n";
} else {
    echo "Verification failed: record not soft-deleted in DB\n";
}

$http->terminate($request, $response);
