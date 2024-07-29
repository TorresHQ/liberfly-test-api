<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_can_get_list_of_users()
    {
        $user = User::where('email', 'melissa@liberfly.com')->first();
        $this->actingAs($user);
        
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/user');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_unauthenticated_user_cannot_get_list_of_users()
    {
        $response = $this->getJson('/api/v1/user');

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthenticated.'
         ]);
    }

    public function test_can_get_user_by_id()
    {
        $user = User::where('email', 'melissa@liberfly.com')->first();
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/user/{$user->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at->toISOString(),
            'updated_at' => $user->updated_at->toISOString(),
        ]);
    }

    public function test_unauthenticated_user_cannot_get_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/v1/user/{$user->id}");

        $response->assertStatus(401);

        $response->assertJson([
           'message' => 'Unauthenticated.'
        ]);
    }

    public function test_get_user_by_id_not_found()
    {
        $user = User::where('email', 'melissa@liberfly.com')->first();
        $this->actingAs($user);
        
        $randomUuid = Str::uuid();

        $response = $this->getJson('/api/v1/user/' . $randomUuid);

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Not Found.'
        ]);
    }
}
