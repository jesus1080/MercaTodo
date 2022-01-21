<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function aUserNotAutenticateNotCanListClients(){
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);

    }
    /** @test */
    public function testAUserClientAuthNotCanListUsers(){
        Role::create(['name' => 'client']);
        $user = User::factory()->create()->assignRole('client');
        $this->actingAs($user);
        $response = $this->get((route('users.index')));
        $response->assertStatus(403);
    }
    /** @test */
    public function testUserAdminAutenticatedCanListUsers(){
        Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
        $responUs = $response->getOriginalContent();
        $users = $responUs['page']['props']['users'];
        $this->assertEquals($user->id, $users[0]['id']);
    }
}
