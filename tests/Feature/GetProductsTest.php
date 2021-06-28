<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_response()
    {
        $response = $this->get('api/products');

        $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonFragment([
            'current_page' => 1,
            'total' => 0,
            'last_page' => 1,
            'per_page' => 20,
            'data' => []
        ]);
    }

    public function test_paginate_parameter()
    {
        $response = $this->get('api/products?paginate=10');

        $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonFragment([
            'current_page' => 1,
            'total' => 0,
            'last_page' => 1,
            'per_page' => 10,
            'data' => []
        ]);
    }

    public function test_page_parameter()
    {
        $response = $this->get('api/products?page=2');

        $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonFragment([
            'current_page' => 2,
            'total' => 0,
            'last_page' => 1,
            'per_page' => 20,
            'data' => []
        ]);
    }

    public function test_invalid_parameters()
    {
        $response = $this->get('api/products?page=bar&paginate=foo');

        $response->assertStatus(422);
    }

    public function test_full_seeded_response()
    {
        $this->seed();

        $response = $this->get('api/products');

        $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonFragment([
            'current_page' => 1,
            'total' => 50,
            'last_page' => 3,
            'per_page' => 20
        ]);
    }

    public function test_pagination()
    {
        $this->seed();

        $response = $this->get('api/products?page=2&paginate=5');

        $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonFragment([
            'current_page' => 2,
            'total' => 50,
            'last_page' => 10,
            'per_page' => 5
        ]);
    }

    public function test_search_parameter()
    {
        $this->seed();

        $response = $this->get('api/products?search=foo');

        $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonFragment([
            'current_page' => 1,
            'per_page' => 20
        ]);
    }
}
