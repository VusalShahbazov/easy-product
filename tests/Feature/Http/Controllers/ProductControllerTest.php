<?php

namespace Tests\Feature\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    use DatabaseMigrations , RefreshDatabase;
    /**
     * @test
     */
    public function test_get_all_products()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200)->assertJsonStructure([]);
    }
    /**
     * @test
     */
    public function test_if_in_database_and_active_then_in_get_all()
    {
        factory(Product::class)->create([
            'title' => 'product321',
            'is_active' => true,
        ]);
        factory(Product::class)->create([
            'title' => 'product123',
            'is_active' => false,

        ]);
        $response = $this->get('/api/products');
        $response->assertStatus(200)
            ->assertDontSeeText('product123')
            ->assertSee('product321')
            ->assertJsonStructure([
                'data' => [
                    ['id', 'title']
                 ],
                'total'
            ]);
    }
    /**
     * @test
     */
    public function store_product()
    {
        $response = $this->post('/api/products', [
            'title' => 'T-shirt',
            'count' => 12,
            'is_active' => true,
            'category_id' => Category::create(['name'=> 'category9'])->id
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'title' , 'created_at', 'updated_at', 'is_active'
            ]);

        $this->assertDatabaseHas('products', [
            'title' => 'T-shirt',
            'count' => 12,
            'is_active' => true
        ]);
    }
    /**
     * @test
     */
    public function update_product()
    {
        $product = factory(Product::class)->create([
            'title' => 'product5',
        ]);
        $this->put("/api/products/{$product->id}", [
            'title' => 'product6',
            'description' => 'some text',
            'is_active' => false
        ])->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'product6',
            'description' => 'some text',
            'is_active' => false
        ]);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'title' => 'product5'
        ]);
    }
    /**
     * @test
     */
    public function delete_product()
    {
        $product = factory(Product::class)->create([
            'title' => 'product5',
        ]);
        $this->delete("/api/products/{$product->id}")->assertStatus(200);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }

    public function show_product_depends_on_is_active_field()
    {
        $a = factory(Product::class)->create([
            'is_active' => true,
        ]);
        $b = factory(Product::class)->create([
            'is_active' => false,
        ]);
        $this->get("/api/products/{$a->id}")->assertStatus(200);
        $this->get("/api/products/{$b->id}")->assertStatus(404);
    }

}
