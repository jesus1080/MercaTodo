<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Inertia\Testing\Assert;
use Spatie\Permission\Models\Role;
use App\Models\User;

class IndexTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function testaUserClientAutenticateCanListProducts(): void
    {
        $this->withoutExceptionHandling();
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $products = Product::factory(10)->create();
        $response = $this->get(route('productsClient.index'));
        $response->assertInertia(
            fn (Assert $page) => $page
              ->component('Product/ProductsShow')
              ->has(
                  'products',
                  fn (Assert $page) => $page
              ->where('total', 10)
              ->where('last_page', 4)
              ->has('data', 3)
              ->etc()
              )
        );
        $response->assertStatus(200);
    }

    /** @test */
    public function testaUserAdminAutenticateCanListProductsWithActions(): void
    {
        $this->withoutExceptionHandling();
        Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $products = Product::factory(10)->create();
        $response = $this->get(route('products.store'));
        $response->assertInertia(
            fn (Assert $page) => $page
        ->component('Product/Products')
        ->has(
            'products',
            fn (Assert $page) => $page
        ->where('total', 10)
        ->where('last_page', 3)
        ->has('data', 4)
        ->etc()
        )
        );
        $response->assertStatus(200);
    }
}
