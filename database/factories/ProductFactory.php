<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => Str::random(10),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam semper libero neque, vel molestie metus venenatis nec. Cras vehicula massa ex, eu molestie dolor pharetra at. Etiam posuere blandit tortor, eu tempus mi aliquet vel. Donec ultrices diam a ultrices commodo. Phasellus egestas posuere purus, scelerisque lacinia mauris tempor ac. Praesent id lacinia nisl. Aenean a nunc in augue porttitor fringilla quis id velit. Proin id elit felis.',
            'sku' => Str::random(10),
            'barcode' => 1867584938574,
            'price' => 100,
            'stock_quantity' => 1
        ];
    }
}
