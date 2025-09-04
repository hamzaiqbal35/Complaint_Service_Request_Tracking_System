<?php

namespace Tests\Unit;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Category;
use App\Models\ComplaintLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintTest extends TestCase
{
    use RefreshDatabase;

    public function test_complaint_belongs_to_creator()
    {
        $user = User::factory()->create();
        $complaint = Complaint::factory()->create([
            'created_by' => $user->id,
            'priority' => 'medium'
        ]);

        $this->assertInstanceOf(User::class, $complaint->creator);
        $this->assertEquals($user->id, $complaint->creator->id);
    }

    public function test_complaint_belongs_to_category()
    {
        $category = Category::factory()->create();
        $complaint = Complaint::factory()->create([
            'category_id' => $category->id,
            'priority' => 'medium'
        ]);

        $this->assertInstanceOf(Category::class, $complaint->category);
        $this->assertEquals($category->id, $complaint->category->id);
    }

    public function test_complaint_has_many_logs()
    {
        $complaint = Complaint::factory()->create(['priority' => 'medium']);
        $log = ComplaintLog::factory()->create([
            'complaint_id' => $complaint->id,
            'user_id' => User::factory()->create()->id,
            'action' => 'status_update',
            'message' => 'Status updated',
            'meta' => []
        ]);

        $this->assertTrue($complaint->logs->contains($log));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $complaint->logs);
        $this->assertEquals(1, $complaint->logs->count());
    }

    public function test_complaint_status_updates()
    {
        $complaint = Complaint::factory()->create([
            'status' => 'pending',
            'priority' => 'medium'
        ]);
        
        $complaint->update(['status' => 'in_progress']);
        $this->assertEquals('in_progress', $complaint->fresh()->status);
    }

    public function test_complaint_can_have_assignee()
    {
        $user = User::factory()->create(['role' => 'staff']);
        $complaint = Complaint::factory()->create([
            'assigned_to' => $user->id,
            'priority' => 'medium'
        ]);

        $this->assertInstanceOf(User::class, $complaint->assignee);
        $this->assertEquals($user->id, $complaint->assignee->id);
    }
}
