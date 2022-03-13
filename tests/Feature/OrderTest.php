<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()
            ->for(Customer::factory()->create([
                'email' => 'johndoe@gmail.com'
            ]))
            ->create();
    }

    /**
     * @test
     */
    public function order_can_be_created()
    {
        $this->assertModelExists($this->order);

        $this->assertEquals(0, $this->order->total);

        $this->assertCount(0, $this->order->lines);

        $this->assertEquals('johndoe@gmail.com', $this->order->customer->email);
    }

    /**
     * @test
     */
    public function order_lines_can_be_added_to_order()
    {
        OrderLine::factory(3)
            ->for($this->order)
            ->create();

        $this->assertCount(3, $this->order->lines);
    }

    /**
     * @test
     */
    public function order_total_equals_sum_of_order_lines()
    {
        $productPrices = [15, 25, 60];

        collect($productPrices)->each(fn ($productPrice) => $this->createOrderLine($productPrice));

        $this->order->recalculate();
        $this->assertCount(3, $this->order->lines);
        $this->assertEquals(100, $this->order->total);
    }

    /**
     * @test
     */
    public function order_line_contains_product_and_related_products()
    {
        $orderLine = $this->createOrderLine(10, [10, 10], 2);


        $this->order->recalculate();

        $this->assertCount(2, $orderLine->relatedProducts);
        $this->assertEquals(60, $orderLine->total);
        $this->assertEquals(60, $this->order->total);

        $this->assertDatabaseHas('order_lines', [
            'id' => $orderLine->id,
            'total' => 60
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'total' => 60
        ]);

        $orderLine2 = $this->createOrderLine(10, [10, 10, 10], 1);
        $this->order->refresh()->recalculate();

        $this->assertCount(3, $orderLine2->relatedProducts);
        $this->assertEquals(40, $orderLine2->total);


        $this->assertDatabaseHas('order_lines', [
            'id' => $orderLine2->id,
            'total' => 40
        ]);

        $this->assertEquals(100, $this->order->total);

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'total' => 100
        ]);
    }

    private function createOrderLine($productPrice = 100, array $relatedProductPrices = [], $quantity = 1): OrderLine
    {
        $orderLine = OrderLine::factory()
            ->forProduct([
                'price' => $productPrice
            ])
            ->for($this->order)
            ->create(compact('quantity'));

        collect($relatedProductPrices)->each(
            fn ($price) =>
            RelatedProduct::factory()
                ->hasAttached($orderLine, [
                    'price' => $price,
                    'quantity' => 1
                ])
                ->create(compact('price'))
        );

        $orderLine->recalculate();

        return $orderLine;
    }
}
