<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Inertia\Testing\Assert;

class IndexTest extends TestCase
{
    use RefreshDatabase;
   
        
    /** @test */
    public function aUserAutenticateCanListProducts(){
            
            $this->withoutExceptionHandling();
            $products = Product::factory(10)->create();
            $response = $this->get(route('products.index'));
            $response->assertInertia(fn (Assert $page) => $page
              ->component('Products')
              ->has('products',fn (Assert $page) => $page
              ->where('total',10)
              ->where('last_page',3)
              ->has('data', 4)
              ->etc()
              )
              
            );
            $response->assertStatus(200);
    }
    
}
