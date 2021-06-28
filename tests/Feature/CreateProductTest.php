<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_without_arguments()
    {
        $response = $this->post('api/products');

        $response->assertStatus(422);
    }

    public function test_invalid_stock_quantity()
    {
        $response = $this->post('api/products', [
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
        $response = $this->post('api/products', [
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
        $response = $this->post('api/products', [
            'name' => 'name teste',
            'description' => 'description test',
            'sku' => 'sku-test',
            'barcode' => 29475869403841,
            'price' => 100,
            'stock_quantity' => 1,
        ]);

        $response->assertStatus(422);
    }

    public function test_valid_arguments()
    {
        $response = $this->post('api/products', [
            'name' => 'name teste',
            'description' => 'description test',
            'sku' => 'sku-test',
            'barcode' => 2947586940384,
            'price' => 100.5,
            'stock_quantity' => 1,
        ]);

        $response->assertStatus(201);
    }
}
