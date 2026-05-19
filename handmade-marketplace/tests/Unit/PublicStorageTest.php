<?php

namespace Tests\Unit;

use App\Support\PublicStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicStorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_null_for_missing_file(): void
    {
        $this->assertNull(PublicStorage::url('products/missing.jpg'));
    }

    public function test_returns_asset_url_for_existing_file(): void
    {
        Storage::disk('public')->put('products/test.jpg', 'fake');

        $url = PublicStorage::url('products/test.jpg');

        $this->assertNotNull($url);
        $this->assertStringContainsString('/storage/products/test.jpg', $url);
    }
}
