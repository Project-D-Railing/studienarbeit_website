<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_welcome_route_http_code()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }

    public function test_home_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/home');

        $this->assertEquals(200, $response->status());
    }

    public function test_home_route_http_code302()
    {
        $response = $this->call('GET', '/home');

        $this->assertEquals(302, $response->status());
    }

    public function test_train_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/train');

        $this->assertEquals(200, $response->status());
    }

    public function test_train_find_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/train/find');

        $this->assertEquals(200, $response->status());
    }

    public function test_train_delay_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/train/ICE/3/delay');

        $this->assertEquals(200, $response->status());
    }

    public function test_station_detail_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/8000191');

        $this->assertEquals(200, $response->status());
    }

    public function test_station_find_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/find');

        $this->assertEquals(200, $response->status());
    }

    public function test_station_train_per_platform_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/trainperplatform/8000191');

        $this->assertEquals(200, $response->status());
    }

    public function test_station_showdate_route_http_code200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/8000191/2018-03-02');

        $this->assertEquals(200, $response->status());
    }
}
