<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Inertia\Testing\Assert;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;


    public function testAuserClientCanSeeViewShowProduct(): void
    {
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $product = Product::factory()->create();
        $response = $this->get(route('productsClient.show'));
        $response->assertStatus(200);
    }

}