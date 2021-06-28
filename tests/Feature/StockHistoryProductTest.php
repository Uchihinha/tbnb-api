<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockHistoryProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_history_non_existent_product()
    {
        $response = $this->get('api/products/100/history');

        $response->assertStatus(404);
    }

    public function test_stock_history_recently_created_product()
    {
        $this->seed();

        $product = Product::first();

        $response = $this->getJson("api/products/$product->id/history");

        $response->assertStatus(200)
        ->assertJsonCount(1)
        ->assertJsonFragment(['old_quantity' => 0, 'new_quantity' => 1]);
    }

    public function test_stock_history_updated_product()
    {
        $this->seed();

        $product = Product::first();

        $product->update([
            'stock_quantity' => 2
        ]);

        $response = $this->getJson("api/products/$product->id/history");

        $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonFragment(['old_quantity' => 0, 'new_quantity' => 1])
        ->assertJsonFragment(['old_quantity' => 1, 'new_quantity' => 2]);
    }
}
