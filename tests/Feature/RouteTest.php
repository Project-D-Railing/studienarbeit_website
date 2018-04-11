<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testWelcomeRouteHTTPCode()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }
    
    public function testHomeRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/home');

        $this->assertEquals(200, $response->status());
    }
    public function testHomeRouteHTTPCode302()
    {
        $response = $this->call('GET', '/home');

        $this->assertEquals(302, $response->status());
    }
    
    public function testTrainRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/train');

        $this->assertEquals(200, $response->status());
    }

    public function testTrainFindRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/train/find');

        $this->assertEquals(200, $response->status());
    }
    
    public function testTrainDelayRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/train/ICE/3/delay');

        $this->assertEquals(200, $response->status());
    }
    
    public function testStationDetailRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/8000191');

        $this->assertEquals(200, $response->status());
    }
    
    public function testStationFindRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/find');

        $this->assertEquals(200, $response->status());
    }
    
    public function testStationTrainPerPlatformRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/trainperplatform/8000191');

        $this->assertEquals(200, $response->status());
    }
    
    public function testStationShowdateRouteHTTPCode200()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/station/8000191/2018-03-02');

        $this->assertEquals(200, $response->status());
    }
}
