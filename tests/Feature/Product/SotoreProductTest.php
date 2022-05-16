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

class StoreProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testAuserClientCanNotSeeViewCreateProduct(): void
    {
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $products = Product::factory(10)->create();
        $response = $this->get(route('products.create'));
        $response->assertStatus(403);
    }

    public function testAuserAdminCanSeeViewCreateProduct(): void
    {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $products = Product::factory(10)->create();
        $response = $this->get(route('products.create'));
        $response->assertStatus(200);
    }

    public function testAuserAdminCanCreateProduct(): void
    {
        $this->withoutExceptionHandling();
        Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $data = $this->productData();
        $response = $this->post(route('products.store'), $data);
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', Arr::except($data, ['image']));
    }

    /**
     * @param array $data
     * @param string $field
     * @return void
     * @dataProvider invalidDataProvider
     */
    public function testValidateStore(array $data, string $field): void
    {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $response = $this->post(route('products.store'), $data);
        $response->assertSessionHasErrors($field);
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

    public function invalidDataProvider(): array
    {
        return [
            'validate rule name string' => [
                'data' => array_replace(
                    $this->productData(),
                    ['name' => 3]
                ),
                'field' => 'name'
            ],

            'validate rule name required' => [
                    'data' => array_replace(
                        $this->productData(),
                        ['name' => null]
                    ),
                    'field' => 'name'
            ],

            'validate rule name min 5' => [
                'data' => array_replace(
                    $this->productData(),
                    ['name' => 'tes']
                ),
                'field' => 'name'
            ],

            'validate rule name max 100' => [
                'data' => array_replace(
                    $this->productData(),
                    ['name' => Str::random(101)]
                ),
                'field' => 'name'
            ],

            'validate rule price required' => [
                'data' => array_replace(
                    $this->productData(),
                    ['price' => null]
                ),
                'field' => 'price'
            ],

            'validate rule price integer' => [
                'data' => array_replace(
                    $this->productData(),
                    ['price' => 'test']
                ),
                'field' => 'price'
            ],

            'validate rule stock required' => [
                'data' => array_replace(
                    $this->productData(),
                    ['stock' => null]
                ),
                'field' => 'stock'
            ],

            'validate rule stock integer' => [
                'data' => array_replace(
                    $this->productData(),
                    ['stock' => 'test']
                ),
                'field' => 'stock'
            ],

            'validate rule description required' => [
                'data' => array_replace(
                    $this->productData(),
                    ['description' => null]
                ),
                'field' => 'description'
            ],

            'validate rule description min 10' => [
                'data' => array_replace(
                    $this->productData(),
                    ['description' => 'test']
                ),
                'field' => 'description'
            ],

            'validate rule description max 255' => [
                'data' => array_replace(
                    $this->productData(),
                    ['description' => Str::random(259)]
                ),
                'field' => 'description'
            ],

            'validate rule image image' => [
                'data' => array_replace(
                    $this->productData(),
                    ['image' =>  UploadedFile::fake()->create('document.pdf', 100, 'application/pdf')]
                ),
                'field' => 'image'
            ],

            'validate rule image required' => [
                'data' => array_replace(
                    $this->productData(),
                    ['image' =>  null]
                ),
                'field' => 'image'
            ],
        ];
    }
}
