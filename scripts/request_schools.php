<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap the application (console kernel) so facades and auth are available
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

// Log in as user ID 1 (super-admin seeded earlier)
Illuminate\Support\Facades\Auth::loginUsingId(1);

$http = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/super-admin/schools', 'GET');
$response = $http->handle($request);

echo "STATUS: " . $response->getStatusCode() . "\n";
// output first 1200 chars of content
$content = (string) $response->getContent();
echo substr($content, 0, 1200);

$http->terminate($request, $response);
