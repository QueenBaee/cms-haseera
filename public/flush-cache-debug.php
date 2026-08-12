<?php

// Script debug sementara — hapus setelah selesai
// Akses via: http://cms-haseera.test/flush-cache-debug.php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

// Flush semua cache
Cache::flush();

echo '<pre>';
echo "=== CACHE FLUSHED ===\n\n";
echo 'base_path: '.base_path()."\n";
echo 'app_env: '.config('app.env')."\n";
echo 'app_url: '.config('app.url')."\n";
echo 'db_connection: '.config('database.default')."\n";
echo 'db_name: '.DB::connection()->getDatabaseName()."\n";
echo 'db_host: '.config('database.connections.mysql.host')."\n";
echo 'db_port: '.config('database.connections.mysql.port')."\n\n";

echo "=== SERVICES AKTIF ===\n";
$services = Service::active()->ordered()->get(['id', 'title', 'slug', 'is_featured', 'is_active', 'sort_order']);
foreach ($services as $s) {
    echo "[{$s->sort_order}] {$s->title} | featured: ".($s->is_featured ? 'true' : 'false').' | active: '.($s->is_active ? 'true' : 'false')."\n";
}

echo "\n=== ALL SERVICES (with trashed) ===\n";
$all = Service::withTrashed()->orderBy('id')->get(['id', 'title', 'deleted_at']);
foreach ($all as $s) {
    echo "[{$s->id}] {$s->title} | deleted_at: ".($s->deleted_at ?? 'null')."\n";
}
echo '</pre>';
