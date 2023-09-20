<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase , WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function it_can_get_categories ()
    {
        $categories = Category::factory()->count(5)->create();

        $response = $this->get(route('categories.index'));

        // dd($response->json('data'));
        
        $response->assertOk();
    }
}
