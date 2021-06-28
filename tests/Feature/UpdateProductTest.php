<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_non_existent_product()
    {
        $response = $this->put('api/products/100', [
            'name' => 'updated name',
            'description' => 'updated description',
            'price' => 1,
            'stock_quantity' => 1
        ]);

        $response->assertStatus(404);
    }

    public function test_invalid_stock_quantity()
    {
        $response = $this->put('api/products/100', [
            'name' => 'name teste',
            'description' => 'description test',
            'sku' => 'sku-test',
            'barcode' => 2947586940384,
            'price' => 100.5,
            'stock_quantity' => null,
        ]);

        $response->assertStatus(422);
    }

    public function test_invalid_price()
    {
        $response = $this->put('api/products/100', [
            'name' => 'name teste',
            'description' => 'description test',
            'sku' => 'sku-test',
            'barcode' => 2947586940384,
            'price' => null,
            'stock_quantity' => 1,
        ]);

        $response->assertStatus(422);
    }

    public function test_invalid_barcode()
    {
        $response = $this->put('api/products/100', [
            'name' => 'name teste',
            'description' => 'description test',
            'sku' => 'sku-test',
            'barcode' => 29475869403841,
            'price' => 100,
            'stock_quantity' => 1,
        ]);

        $response->assertStatus(422);
    }

    public function test_without_body_arguments()
    {
        $response = $this->put('api/products/100');

        $response->assertStatus(422);
    }

    public function test_valid_arguments() {
        $this->seed();

        $product = Product::first();

        $response = $this->put('api/products/' . $product->id, [
            'name' => 'updated name',
            'description' => 'updated description',
            'price' => 1,
            'stock_quantity' => 1
        ]);

        $response->assertStatus(200);
    }
}
