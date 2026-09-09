<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminParticipantAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_edit_participants(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $participant = User::factory()->create(['is_admin' => false]);

        $this->actingAs($admin)
            ->get(route('admin.participants.index'))
            ->assertOk()
            ->assertSee($participant->email);

        $this->actingAs($admin)
            ->get(route('admin.participants.show', $participant))
            ->assertOk()
            ->assertSee($participant->email);

        $this->actingAs($admin)
            ->get(route('admin.participants.edit', $participant))
            ->assertOk();

        $this->actingAs($admin)
            ->put(route('admin.participants.update', $participant), [
                'name' => 'Updated Name',
                'full_name' => 'Updated Full Name',
                'email' => $participant->email,
                'school_origin' => 'Updated School',
            ])
            ->assertRedirect(route('admin.participants.show', $participant));

        $this->assertDatabaseHas('users', [
            'id' => $participant->id,
            'name' => 'Updated Name',
            'school_origin' => 'Updated School',
        ]);
    }

    public function test_superadmin_can_view_and_delete_participants(): void
    {
        $superadmin = User::factory()->create([
            'is_admin' => true,
            'is_superadmin' => true,
        ]);
        $participant = User::factory()->create(['is_admin' => false]);

        $this->actingAs($superadmin)
            ->get(route('admin.participants.show', $participant))
            ->assertOk()
            ->assertSee($participant->email);

        $this->actingAs($superadmin)
            ->delete(route('admin.participants.destroy', $participant))
            ->assertRedirect(route('admin.participants.index'));

        $this->assertDatabaseMissing('users', ['id' => $participant->id]);
    }

    public function test_admin_cannot_edit_or_delete_an_admin_account_as_a_participant(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $otherAdmin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.participants.edit', $otherAdmin))
            ->assertNotFound();

        $this->actingAs($admin)
            ->delete(route('admin.participants.destroy', $otherAdmin))
            ->assertNotFound();

        $this->assertDatabaseHas('users', ['id' => $otherAdmin->id]);
    }
}
