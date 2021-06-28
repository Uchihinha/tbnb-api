<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FindProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_non_existent_product()
    {
        $response = $this->get('api/products/100');

        $response->assertStatus(404);
    }

    public function test_get_existent_product()
    {
        $this->seed();

        $product = Product::first();

        $response = $this->get('api/products/' . $product->id);

        $response->assertStatus(200)
        ->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'created_at' => $product->created_at,
        ]);
    }
}
