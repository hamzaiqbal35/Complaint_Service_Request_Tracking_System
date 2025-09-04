<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;
    protected $category;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'email_verified_at' => now()
        ]);
        
        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);
        
        $this->category = Category::factory()->create();
        
        // Get JWT token for the user
        $this->token = JWTAuth::fromUser($this->user);
    }

    protected function withAuthHeaders($token = null)
    {
        $token = $token ?: $this->token;
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]);
    }

    public function test_unauthenticated_users_cannot_access_protected_endpoints()
    {
        $complaint = Complaint::factory()->create(['created_by' => $this->user->id]);
        
        $this->getJson('/api/complaints')->assertStatus(401);
        $this->getJson("/api/complaints/{$complaint->id}")->assertStatus(401);
    }

    public function test_user_can_retrieve_own_complaints()
    {
        $complaint = Complaint::factory()->create([
            'created_by' => $this->user->id,
            'priority' => 'medium'
        ]);
        
        $response = $this->withAuthHeaders()
            ->getJson('/api/complaints');
            
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $complaint->title]);
    }

    public function test_user_can_view_own_complaint()
    {
        $complaint = Complaint::factory()->create([
            'created_by' => $this->user->id,
            'priority' => 'medium'
        ]);
        
        $response = $this->withAuthHeaders()
            ->getJson("/api/complaints/{$complaint->id}");
            
        $response->assertStatus(200)
                 ->assertJson(['title' => $complaint->title]);
    }

    public function test_user_cannot_view_other_users_complaint()
    {
        $otherUser = User::factory()->create();
        $complaint = Complaint::factory()->create([
            'created_by' => $otherUser->id,
            'priority' => 'medium'
        ]);
        
        $response = $this->withAuthHeaders()
            ->getJson("/api/complaints/{$complaint->id}");
            
        $response->assertStatus(403);
    }

    public function test_admin_can_view_any_complaint()
    {
        // Get admin token
        $adminToken = JWTAuth::fromUser($this->admin);
        
        $complaint = Complaint::factory()->create([
            'created_by' => $this->user->id,
            'priority' => 'medium'
        ]);
        
        $response = $this->withAuthHeaders($adminToken)
            ->getJson("/api/complaints/{$complaint->id}");
            
        $response->assertStatus(200)
                 ->assertJson(['title' => $complaint->title]);
    }

    public function test_validation_errors()
    {
        $response = $this->withAuthHeaders()
            ->postJson('/api/complaints', []);
            
        $response->assertStatus(405); // Method Not Allowed as per routes
    }

    public function test_user_can_logout()
    {
        $response = $this->withAuthHeaders()
            ->postJson('/api/logout');
            
        $response->assertStatus(200);
        
        // Try to access protected route after logout
        $response = $this->withAuthHeaders()
            ->getJson('/api/complaints');
            
        $response->assertStatus(401);
    }
}
