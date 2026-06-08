<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

$http = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/debug/super-admin/dashboard', 'GET');
$response = $http->handle($request);

echo "STATUS: " . $response->getStatusCode() . "\n";
echo substr((string) $response->getContent(), 0, 1200);

$http->terminate($request, $response);
