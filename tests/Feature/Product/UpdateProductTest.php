<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Inertia\Testing\Assert;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function testUserClientCanNotUpdateProduct(): void
    {
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $product = Product::factory()->create();
        $response = $this->get(route('products.edit', compact('product')));
        $response->assertStatus(403);
    }


    public function testUserAdminCanUpdateProduct(): void
    {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $product = Product::factory()->create();
        $data = $this->productData();
        $response = $this->put(route('products.update', $product), $data, [
            'name',
            'price',
            'description',
            'image',
            'stock',
            'status',
        ]);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', Arr::except($data, ['image']));
        $response->assertRedirect(route('products.index'));
    }

    private function productData(): array
    {
        return[
            'name' => 'Product test',
            'price' => 60000,
            'description' => 'product test',
            'image' => UploadedFile::fake()->image('product.jpg', 500, 250)->size(50),
            'stock' => 5,
            'status' => true,
        ];
    }
}
