<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BulkUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_bulk_update_non_existent_product()
    {
        $response = $this->put('api/products/bulk', [
            "products" => [4, 5],
            "stock_quantity" => 15,
            "price" => 15
        ]);

        $response->assertStatus(422);
    }

    public function test_bulk_update_and_stock_history()
    {
        $this->seed();

        $products = Product::take(4)->orderBy('id')->get();

        $response = $this->put('api/products/bulk', [
            "products" => $products->pluck('id')->toArray(),
            "stock_quantity" => 15,
            "price" => 15
        ]);

        $response->assertStatus(200);

        foreach ($products as $key => $product) {
            $responseHistory = $this->getJson("api/products/$product->id/history");

            $responseHistory->assertStatus(200)
            ->assertJsonCount(2);
        }

    }
}
