<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StudentReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_their_submitted_reports(): void
    {
        $user = User::factory()->create();

        Report::create([
            'report_type' => 'Daily Report',
            'title' => 'My first report',
            'description' => 'This is my report description.',
            'photos' => ['reports/test.jpg'],
            'submitted_by' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/submitted-reports');

        $response->assertOk();
        $response->assertSee('My first report');
    }

    public function test_student_can_edit_and_delete_their_own_report(): void
    {
        $user = User::factory()->create();

        $report = Report::create([
            'report_type' => 'Weekly Report',
            'title' => 'Old report title',
            'description' => 'Old description',
            'photos' => ['reports/old.jpg'],
            'submitted_by' => $user->id,
        ]);

        $this->actingAs($user)
            ->put('/reports/' . $report->id, [
                'report_type' => 'Daily Report',
                'nama_project' => 'Updated report title',
                'penjelasan_project' => 'Updated description',
            ])
            ->assertRedirect('/submitted-reports');

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'title' => 'Updated report title',
            'description' => 'Updated description',
        ]);

        $this->actingAs($user)
            ->delete('/reports/' . $report->id)
            ->assertRedirect('/submitted-reports');

        $this->assertDatabaseMissing('reports', ['id' => $report->id]);
    }

    public function test_student_can_add_more_report_photos_when_editing(): void
    {
        $user = User::factory()->create();

        $report = Report::create([
            'report_type' => 'Daily Report',
            'title' => 'Report with photo',
            'description' => 'Old description',
            'photos' => ['reports/old-photo.jpg'],
            'submitted_by' => $user->id,
        ]);

        $this->actingAs($user)
            ->from('/reports/' . $report->id . '/edit')
            ->put('/reports/' . $report->id, [
                'report_type' => 'Daily Report',
                'nama_project' => 'Report with photo',
                'penjelasan_project' => 'Updated description',
                'photos' => [
                    UploadedFile::fake()->create('new-photo.jpg', 100, 'image/jpeg'),
                ],
            ])
            ->assertRedirect('/submitted-reports');

        $report->refresh();
        $this->assertContains('reports/old-photo.jpg', $report->photos);
        $this->assertCount(2, $report->photos);
    }

    public function test_student_can_remove_existing_report_photo_when_editing(): void
    {
        $user = User::factory()->create();

        $report = Report::create([
            'report_type' => 'Daily Report',
            'title' => 'Report with multiple photos',
            'description' => 'Old description',
            'photos' => ['reports/old-photo-1.jpg', 'reports/old-photo-2.jpg'],
            'submitted_by' => $user->id,
        ]);

        $this->actingAs($user)
            ->from('/reports/' . $report->id . '/edit')
            ->put('/reports/' . $report->id, [
                'report_type' => 'Daily Report',
                'nama_project' => 'Report with multiple photos',
                'penjelasan_project' => 'Updated description',
                'removed_photos' => ['reports/old-photo-1.jpg'],
            ])
            ->assertRedirect('/submitted-reports');

        $report->refresh();
        $this->assertNotContains('reports/old-photo-1.jpg', $report->photos);
        $this->assertContains('reports/old-photo-2.jpg', $report->photos);
        $this->assertCount(1, $report->photos);
    }

    public function test_admin_announcement_submission_is_recorded_in_submitted_reports(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post('/announcement', [
                'title' => 'Pengumuman baru',
                'content' => 'Detail pengumuman',
                'image' => UploadedFile::fake()->create('announcement.jpg', 100, 'image/jpeg'),
                'file' => UploadedFile::fake()->create('announcement.pdf', 500, 'application/pdf'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('reports', [
            'report_type' => 'Announcement',
            'title' => 'Pengumuman baru',
            'submitted_by' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get('/submitted-reports')
            ->assertOk()
            ->assertSee('Pengumuman baru');
    }

    public function test_announcement_is_hidden_from_public_report_lists(): void
    {
        $user = User::factory()->create();

        Report::create([
            'report_type' => 'Daily Report',
            'title' => 'Daily report visible',
            'description' => 'This should appear in public report list.',
            'photos' => ['reports/daily.jpg'],
            'submitted_by' => $user->id,
        ]);

        Report::create([
            'report_type' => 'Announcement',
            'title' => 'Pengumuman rahasia',
            'description' => 'This should not appear on the public report page.',
            'photos' => ['reports/announcement.jpg'],
            'submitted_by' => $user->id,
        ]);

        $this->get('/lapor')
            ->assertOk()
            ->assertSee('Daily report visible')
            ->assertDontSee('Pengumuman rahasia');

        $this->get('/lapor-all')
            ->assertOk()
            ->assertSee('Daily report visible')
            ->assertDontSee('Pengumuman rahasia');
    }

    public function test_report_detail_page_displays_selected_report_content(): void
    {
        $report = Report::create([
            'report_type' => 'Daily Report',
            'title' => 'Detailed report title',
            'description' => 'This is the full report detail description.',
            'photos' => ['reports/sample-photo.jpg'],
            'submitted_by' => User::factory()->create()->id,
        ]);

        $this->get('/lapor/' . $report->id)
            ->assertOk()
            ->assertSee('Detailed report title')
            ->assertSee('This is the full report detail description.');
    }
}
