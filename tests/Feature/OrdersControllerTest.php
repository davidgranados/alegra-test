<?php

namespace Tests\Feature;

use App\Events\OrderCreated;
use App\Jobs\BuyIngredients;
use App\Jobs\PrepareOrder;
use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 *
 */
class OrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function createOrders($n, $status = null)
    {
        $recipes = Recipe::all();
        foreach (range(1, $n) as $_) {
            $createdOrders[] =
                Order::create(['recipe_id' => $recipes->random()->id]);
        }
        if ($status) {
            Order::query()->update(['status' => $status]);
        }
    }

    public function test_pending_orders_can_be_listed()
    {
        // Given
        $ordersQty = 10;
        $this->createOrders($ordersQty);
        //When
        $response = $this->get(route('orders.index'));
        $response2 = $this->get(
            route('orders.index', ['status' => Order::PENDING_STATUS]),
        );
        // Then
        $response->assertStatus(Response::HTTP_OK);
        $response2->assertStatus(Response::HTTP_OK);
        $this->assertEquals(count($response->json()['data']), $ordersQty);
        $this->assertEquals(count($response2->json()['data']), $ordersQty);
    }

    public function test_ready_orders_can_be_listed()
    {
        // Given
        $ordersQty = 10;
        $this->createOrders($ordersQty, Order::READY_STATUS);
        //When
        $response = $this->get(
            route('orders.index', ['status' => Order::READY_STATUS]),
        );
        // Then
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals(count($response->json()['data']), $ordersQty);
    }

    public function test_orders_can_be_created()
    {
        Event::fake([
            OrderCreated::class
        ]);
        // Given
        $quantity = 10;
        //When
        $response = $this->post(route('orders.store'), [
            'quantity' => $quantity
        ]);
        // Then
        $response->assertStatus(Response::HTTP_CREATED);
        Event::assertDispatchedTimes(OrderCreated::class, $quantity);
        $this->assertDatabaseCount(with(new Order())->getTable(), $quantity);
    }

    public function test_an_notification_is_send_to_kitchen()
    {
        Queue::fake();
        //When
        $response = $this->post(route('orders.store'));
        // Then
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount(with(new Order())->getTable(), 1);
        Queue::assertPushed(PrepareOrder::class);
    }

}
