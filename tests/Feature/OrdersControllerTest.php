<?php

namespace Tests\Feature;

use App\Events\OrderCreated;
use App\Jobs\BuyIngredients;
use App\Jobs\PrepareOrder;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Stock;
use App\Models\StockReservation;
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

    public function test_stock_reservation()
    {
        // Given
        Stock::query()->update(['quantity' => 1]);
        $recipe = Recipe::find(1);
        // When
        $this->post(route('orders.store'), [
            'recipe' => $recipe->id
        ]);
        // Then
        $this->assertDatabaseCount(
            with(new StockReservation())->getTable(),
            $recipe->ingredients()->count()
        );
    }

    public function test_buy_from_market_event_dispatched()
    {
        Queue::fake();
        // Given
        $recipe = Recipe::find(1);
        $this->post(route('orders.store'), [
            'recipe' => $recipe->id
        ]);
        $order = Order::first();
        // When
        $prepareJob = new PrepareOrder($order);
        $prepareJob->handle();
        // Then
        Queue::assertPushed(BuyIngredients::class);
    }

}
