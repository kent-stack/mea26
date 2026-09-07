<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();
        
        if (!$admin) {
            $this->command->warn('No admin user found. Skipping announcement seeder.');
            return;
        }

        // Create announcements directory if it doesn't exist
        if (!Storage::disk('public')->exists('announcements/files')) {
            Storage::disk('public')->makeDirectory('announcements/files');
        }

        // Create a sample announcement content as text file
        $sampleContent = "PENGUMUMAN\n\nSelamat Kepada Calon Peserta yang lolos Seleksi Wawancara\nInternational Credit Transfer Program 2023.\n\nBerdasarkan hasil seleksi dokumen yang telah dilakukan, kami dengan bangga\nmengumumkan bahwa Anda telah lolos ke tahap berikutnya yaitu wawancara.\n\nTerima kasih telah mengikuti proses seleksi.";

        // Create sample text file
        $txtPath = 'announcements/files/sample-announcement.txt';
        
        try {
            Storage::disk('public')->put($txtPath, $sampleContent);
            
            // Create announcement record
            Announcement::updateOrCreate(
                ['title' => 'Selamat Kepada Calon Peserta yang lolos Seleksi Wawancara International Credit Transfer Program 2023.'],
                [
                    'content' => 'Info date : 9 May 2023. Klik untuk melihat detail pengumuman yang lebih jelas lagi.',
                    'file' => $txtPath,
                    'published_at' => now(),
                    'user_id' => $admin->id,
                ]
            );
            
            $this->command->info('Announcement seeder completed successfully.');
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}
