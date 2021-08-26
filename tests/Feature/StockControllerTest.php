<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_stock_list()
    {
        $response = $this->get(route('stock.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data'=> []]);
    }
}
