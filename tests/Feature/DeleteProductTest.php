<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_non_existent_product()
    {
        $response = $this->delete('api/products/100');

        $response->assertStatus(404);
    }

    public function test_delete_existent_product()
    {
        $this->seed();

        $product = Product::first();

        $response = $this->delete("api/products/$product->id");

        $response->assertStatus(200)
        ->assertJson([
            'message' => 'Deleted'
        ]);

        $response = $this->get('api/products/' . $product->id);

        $response->assertStatus(404);
    }
}
