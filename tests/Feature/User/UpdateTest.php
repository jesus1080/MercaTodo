<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Inertia\Testing\Assert;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testUserNotAuthenticateCanNotEditUser()
    {
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $response = $this->get(route('users.edit', compact('user')));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }
    /** @test */
    public function testUserClientAutenticatedCanNotUpdatedUser()
    {
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $user2 = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $response = $this->get(route('users.edit', [$user2]));
        $response->assertStatus(403);
    }
    /** @test */
    public function testUserAdminAutenticatedCanSeeViewEditUser()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $user2 = User::factory()->create()->assignRole('client');
        $response = $this->get(route('users.edit', [$user2]));
        $response->assertInertia(
            fn (Assert $page) => $page
              ->component('User/EditUser')
              ->has(
                  'user',
                  fn (Assert $page) => $page
                ->where('first_name', $user2->first_name)
                ->etc()
              )
        );
    }
    /** @test */
    public function testUserAdminAutenticatedCanUpdateUser()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('admin');
        $user2 = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $response = $this->put(route('users.update', $user2), [
            'first_name' => 'simon',
            'last_name' => 'luna',
            'phone' => '2333333',
            'active' => '0',
        ], [
            'first_name',
            'last_name',
            'phone',
            'active',
        ]);
        $dbUser = User::where('id', $user2->id)->first();
        $this->assertEquals($dbUser['first_name'], 'simon');
    }
}
