<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleUnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnitTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
