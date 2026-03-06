<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_order_creation_works(): void
    {
        $product = Product::factory()->create([
            'price' => 100,
            'stock_quantity' => 10
        ]);

        $customer = Customer::factory()->create();

        $response = $this->postJson('/api/v1/orders', [
            'customer_id' => $customer->id,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ]);

        $response->assertStatus(201);

        $this->assertEquals(8, $product->fresh()->stock_quantity);

        $this->assertDatabaseHas('orders', [
            'total_amount' => 200
        ]);
    }
}
