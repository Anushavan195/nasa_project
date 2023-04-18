<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AsteroidsControllerTest extends TestCase
{
    public function test_index()
    {
        $response = $this->post('/neo/hazardous');
        $this->assertJson($response->content());
    }

    public function test_getTheFasterAsteroid()
    {
        $response = $this->post('/neo/fastest');
        $this->assertJson($response->content());
    }

    public function test_getBestYearWithAsteroids()
    {
        $response = $this->post('/neo/best-year');
        $this->assertJson($response->content());
    }

    public function test_getBestMonthWithAsteroids()
    {
        $response = $this->post('/neo/best-month');
        $this->assertJson($response->content());
    }
}
