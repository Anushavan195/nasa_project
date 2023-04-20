<?php

namespace Tests\Feature;

use Tests\TestCase;

class AsteroidsControllerTest extends TestCase
{
    public function test_index()
    {
        $response = $this->post('/neo/hazardous');
        $this->assertJson($response->content());

        $response = json_decode($response->content(), true);

        $this->assertIsArray($response);

        $data = $response['data'][0];

        $this->assertArrayHasKey('name', $data);
        $this->assertIsString($data['name']);
        $this->assertArrayHasKey('id', $data);
        $this->assertIsInt($data['id']);
        $this->assertArrayHasKey('date', $data);
        $this->assertIsString($data['date']);
        $this->assertArrayHasKey('reference', $data);
        $this->assertIsString($data['reference']);
        $this->assertArrayHasKey('speed', $data);
        $this->assertIsString($data['speed']);
        $this->assertArrayHasKey('is_hazardous', $data);
        $this->assertIsInt($data['is_hazardous']);
    }

    public function test_getTheFasterAsteroid()
    {
        $response = $this->post('/neo/fastest');
        $this->assertJson($response->content());

        $data = json_decode($response->content(), true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('name', $data);
        $this->assertIsString($data['name']);
        $this->assertArrayHasKey('id', $data);
        $this->assertIsInt($data['id']);
        $this->assertArrayHasKey('date', $data);
        $this->assertIsString($data['date']);
        $this->assertArrayHasKey('reference', $data);
        $this->assertIsString($data['reference']);
        $this->assertArrayHasKey('speed', $data);
        $this->assertIsString($data['speed']);
        $this->assertArrayHasKey('is_hazardous', $data);
        $this->assertIsInt($data['is_hazardous']);
    }

    public function test_getBestYearWithAsteroids()
    {
        $response = $this->post('/neo/best-year');
        $this->assertJson($response->content());

        $data = json_decode($response->content(), true);
        $key = (string)key($data);

        $this->assertIsArray($data[$key]);
        $this->assertArrayHasKey('name', $data[$key][0]);
        $this->assertIsString($data[$key][0]['name']);
        $this->assertArrayHasKey('id', $data[$key][0]);
        $this->assertIsInt($data[$key][0]['id']);
        $this->assertArrayHasKey('date', $data[$key][0]);
        $this->assertIsString($data[$key][0]['date']);
        $this->assertArrayHasKey('reference', $data[$key][0]);
        $this->assertIsString($data[$key][0]['reference']);
        $this->assertArrayHasKey('speed', $data[$key][0]);
        $this->assertIsString($data[$key][0]['speed']);
        $this->assertArrayHasKey('is_hazardous', $data[$key][0]);
        $this->assertIsInt($data[$key][0]['is_hazardous']);

    }

    public function test_getBestMonthWithAsteroids()
    {
        $response = $this->post('/neo/best-month');

        $this->assertJson($response->content());

        $data = json_decode($response->content(), true);
        $key = (string)key($data);

        $this->assertIsArray($data[$key]);
        $this->assertArrayHasKey('name', $data[$key][0]);
        $this->assertIsString($data[$key][0]['name']);
        $this->assertArrayHasKey('id', $data[$key][0]);
        $this->assertIsInt($data[$key][0]['id']);
        $this->assertArrayHasKey('date', $data[$key][0]);
        $this->assertIsString($data[$key][0]['date']);
        $this->assertArrayHasKey('reference', $data[$key][0]);
        $this->assertIsString($data[$key][0]['reference']);
        $this->assertArrayHasKey('speed', $data[$key][0]);
        $this->assertIsString($data[$key][0]['speed']);
        $this->assertArrayHasKey('is_hazardous', $data[$key][0]);
        $this->assertIsInt($data[$key][0]['is_hazardous']);
    }
}
