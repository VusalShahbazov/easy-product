<?php

namespace Tests\Feature\Http\Controllers;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations , RefreshDatabase;

    /**
     * @test
     */
    public function test_get_all_categories()
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
        $response->assertJsonStructure([]);
    }

    /**
     * @test
     */
    public function test_store_category()
    {
        $response = $this->post('/api/categories' , [
            'name' => 'category1'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id','name']);
        $response->assertSee('category1');
        $this->assertDatabaseHas('categories' , [
            'name' =>'category1'
        ]);
    }

    /**
     * @test
     */
    public function test_store_category_get_after_store()
    {
        $this->post('/api/categories' , [
            'name' => 'category2'
        ]);
        $this->assertDatabaseHas('categories' , [
            'name' =>'category2'
        ]);
        $response = $this->get('/api/categories');
        $response->assertJsonStructure([
            [
                'id' , 'name'
            ]
        ]);
        $response->assertSee('category2');
    }

    /**
     * @test
     */
    public function test_update_category()
    {
        $category = factory(Category::class)->create([
            'name' => 'category3'
        ]);
        $response = $this->put("/api/categories/{$category->id}" , [
            'name' => 'category4'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('categories' , [
            'id' => $category->id ,
            'name' => 'category4'
        ]);
    }

    /**
     * @test
     */
    public function test_delete_category()
    {
        $category = factory(Category::class)->create([
            'name' => 'category5'
        ]);
        $response = $this->delete("/api/categories/{$category->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories' , [
            'id' => $category->id
        ]);
    }

    /**
     * @test
     */
    public function test_validation_error_and_json_structure(){
        $response=  $this->post('/api/categories');
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'name' =>[]
        ]);
    }
}
