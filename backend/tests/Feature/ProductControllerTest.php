<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase , WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function it_can_get_products ()
    {
        $products = Product::factory()->count(5)->create();

        $response = $this->get(route('products.index'), [
            'sortBy' => 'price',
            'categoryId' => 3,  
        ]);

        $response->assertOk()
            ->assertJsonStructure(['data' => [['id']]]);
    }

    /** @test */
    public function it_can_create_product ()
    {
        Storage::fake('public');

        $product = Product::factory()->makeOne();
        $categoryIds = Category::factory(3)->create()->pluck('id')->toArray();

        $product['image'] = UploadedFile::fake()->image('product.jpg');
        $product['categories'] = $categoryIds;

        $response = $this->post(route('products.store') , $product->toArray());

        $response->assertStatus(201)
                ->assertJsonStructure(['data' => ['id' , 'name' ,'description','price' , 'image']]);

        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
        ]);
    }
}
