<?php

declare(strict_types=1);

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

test('deleting a brand deletes its logo from the public disk', function () {
    Storage::fake('public');
    Storage::disk('public')->put('brands/acme.svg', 'logo');

    $brand = Brand::create([
        'name' => 'Acme',
        'logo' => 'brands/acme.svg',
    ]);

    $brand->delete();

    Storage::disk('public')->assertMissing('brands/acme.svg');
    $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
});

test('deleting a brand with an empty logo does not access storage', function () {
    Storage::spy();

    $brand = Brand::create([
        'name' => 'Acme',
        'logo' => '',
    ]);

    $brand->delete();

    Storage::shouldNotHaveReceived('disk');
    $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
});
