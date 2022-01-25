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
              ->component('Dashboard')
              ->has('products',10)
            );
            $response->assertStatus(200);
    }
    
}
