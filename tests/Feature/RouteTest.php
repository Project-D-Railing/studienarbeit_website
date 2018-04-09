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
}
