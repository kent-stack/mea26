<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_saved(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->post('/profile', [
                'full_name' => 'Budi Santoso',
                'place_of_birth' => 'Surabaya',
                'date_of_birth' => '2008-06-15',
                'school_origin' => 'SMA Negeri 1 Surabaya',
                'email' => 'budi@example.com',
                'gender' => 'Laki-laki',
                'agama' => 'Islam',
                'kewarganegaraan' => 'WNI',
                'status_pernikahan' => 'Belum Kawin',
                'provinsi' => 'Jawa Timur',
                'kabupaten_kota' => 'Surabaya',
                'jalan' => 'Jl. Merdeka No. 10',
                'dusun' => 'Tegalsari',
                'kecamatan' => 'Wonokromo',
                'kelurahan_desa' => 'Tegalsari',
                'rt' => '08',
                'rw' => '02',
                'kode_pos' => '60243',
                'address' => 'Jl. Merdeka No. 10, Tegalsari, Wonokromo, Surabaya',
                'whatsapp_number' => '081234567890',
                'telegram_number' => '@budisantoso',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Budi Santoso', $user->full_name);
        $this->assertSame('Surabaya', $user->place_of_birth);
        $this->assertSame('SMA Negeri 1 Surabaya', $user->school_origin);
        $this->assertSame('Laki-laki', $user->gender);
        $this->assertSame('Islam', $user->agama);
        $this->assertSame('WNI', $user->kewarganegaraan);
        $this->assertSame('Belum Kawin', $user->status_pernikahan);
        $this->assertSame('081234567890', $user->whatsapp_number);
        $this->assertSame('@budisantoso', $user->telegram_number);
    }

    public function test_profile_requires_valid_information(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->post('/profile', [
                'full_name' => '',
                'place_of_birth' => '',
                'date_of_birth' => '',
                'school_origin' => '',
                'email' => 'not-an-email',
                'gender' => 'Bukan Gender',
                'whatsapp_number' => '',
            ]);

        $response
            ->assertSessionHasErrors([
                'full_name',
                'place_of_birth',
                'date_of_birth',
                'school_origin',
                'email',
                'gender',
                'whatsapp_number',
            ])
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertNull($user->full_name);
        $this->assertNull($user->school_origin);
        $this->assertNull($user->gender);
        $this->assertNull($user->whatsapp_number);
    }

    public function test_profile_requires_numeric_rt_rw_and_valid_postal_code(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->post('/profile', [
                'full_name' => 'Budi Santoso',
                'place_of_birth' => 'Surabaya',
                'date_of_birth' => '2008-06-15',
                'school_origin' => 'SMA Negeri 1 Surabaya',
                'email' => 'budi2@example.com',
                'gender' => 'Laki-laki',
                'whatsapp_number' => '081234567890',
                'rt' => 'A1',
                'rw' => 'B2',
                'kode_pos' => '1234',
            ]);

        $response
            ->assertSessionHasErrors(['rt', 'rw', 'kode_pos'])
            ->assertRedirect('/profile');
    }

    public function test_wilayah_endpoints_return_real_indonesia_data(): void
    {
        Artisan::call('laravolt:indonesia:seed');

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/wilayah/provinces')
            ->assertOk()
            ->assertJsonFragment(['name' => 'JAWA TIMUR']);

        $this
            ->actingAs($user)
            ->get('/wilayah/cities/35')
            ->assertOk()
            ->assertJsonFragment(['name' => 'KOTA MALANG']);
    }

    public function test_village_endpoint_includes_postal_code_for_auto_fill(): void
    {
        Artisan::call('laravolt:indonesia:seed');

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/wilayah/villages/110101')
            ->assertOk()
            ->assertJsonFragment(['postal_code' => '23773']);
    }

    public function test_profile_page_restores_saved_data_for_logged_in_user(): void
    {
        $user = User::factory()->create([
            'full_name' => 'Budi Santoso',
            'place_of_birth' => 'Surabaya',
            'date_of_birth' => '2008-06-15',
            'school_origin' => 'SMA Negeri 1 Surabaya',
            'gender' => 'Laki-laki',
            'whatsapp_number' => '081234567890',
            'provinsi' => 'Jawa Timur',
            'kabupaten_kota' => 'Surabaya',
            'kecamatan' => 'Wonokromo',
            'kelurahan_desa' => 'Tegalsari',
            'kode_pos' => '60243',
        ]);

        $this
            ->actingAs($user)
            ->get('/profile')
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('Surabaya')
            ->assertSee('SMA Negeri 1 Surabaya')
            ->assertSee('Jawa Timur')
            ->assertSee('60243');
    }
}
