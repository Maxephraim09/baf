<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_branding_update_preserves_existing_uploaded_assets_when_no_new_files_are_sent(): void
    {
        $user = User::factory()->create();
        Role::create(['name' => 'superadmin']);
        $user->assignRole('superadmin');

        SiteSetting::create([
            'payload' => [
                'branding' => [
                    'primary_color' => '#111111',
                    'logo_light' => 'http://localhost/storage/settings/light-logo.png',
                    'logo_dark' => '/storage/settings/dark-logo.png',
                    'favicon' => '/storage/settings/favicon.ico',
                ],
            ],
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.settings.update', 'branding'), [
                'primary_color' => '#F53003',
                'primary_color_hex' => '#F53003',
                'secondary_color' => '#1B1B18',
                'secondary_color_hex' => '#1B1B18',
                'accent_color' => '#F8B803',
                'accent_color_hex' => '#F8B803',
                'default_language' => 'en',
                'date_format' => 'Y-m-d',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $branding = SiteSetting::first()->payload['branding'];

        $this->assertSame('/storage/settings/light-logo.png', $branding['logo_light']);
        $this->assertSame('/storage/settings/dark-logo.png', $branding['logo_dark']);
        $this->assertSame('/storage/settings/favicon.ico', $branding['favicon']);
        $this->assertSame('#F53003', $branding['primary_color']);
    }

    public function test_branding_uploads_are_stored_saved_and_rendered_as_existing_previews(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Role::create(['name' => 'superadmin']);
        $user->assignRole('superadmin');
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.settings.update', 'branding'), [
                'primary_color' => '#F53003',
                'primary_color_hex' => '#F53003',
                'secondary_color' => '#1B1B18',
                'secondary_color_hex' => '#1B1B18',
                'accent_color' => '#F8B803',
                'accent_color_hex' => '#F8B803',
                'default_language' => 'en',
                'date_format' => 'Y-m-d',
                'logo_light' => UploadedFile::fake()->createWithContent('light-logo.png', $png),
                'logo_dark' => UploadedFile::fake()->createWithContent('dark-logo.png', $png),
                'favicon' => UploadedFile::fake()->createWithContent('favicon.png', $png),
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertSessionHas('active_tab', 'branding')
            ->assertRedirect();

        $branding = SiteSetting::first()->payload['branding'];

        foreach (['logo_light', 'logo_dark', 'favicon'] as $assetField) {
            $this->assertStringStartsWith('/storage/settings/', $branding[$assetField]);
            Storage::disk('public')->assertExists(str_replace('/storage/', '', $branding[$assetField]));
        }

        $this
            ->actingAs($user)
            ->get(route('admin.settings'))
            ->assertOk()
            ->assertSee($branding['logo_light'], false)
            ->assertSee($branding['logo_dark'], false)
            ->assertSee($branding['favicon'], false);
    }

    public function test_branding_colors_are_saved_and_rendered_as_global_theme_variables(): void
    {
        $user = User::factory()->create();
        Role::create(['name' => 'superadmin']);
        $user->assignRole('superadmin');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.settings.update', 'branding'), [
                'primary_color' => '#0055aa',
                'primary_color_hex' => '#0055aa',
                'secondary_color' => '#223344',
                'secondary_color_hex' => '#223344',
                'accent_color' => '#ffaa00',
                'accent_color_hex' => '#ffaa00',
                'default_language' => 'en',
                'date_format' => 'Y-m-d',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertSessionHas('active_tab', 'branding')
            ->assertRedirect();

        $branding = SiteSetting::first()->payload['branding'];

        $this->assertSame('#0055AA', $branding['primary_color']);
        $this->assertSame('#0055AA', $branding['primary_color_hex']);
        $this->assertSame('#223344', $branding['secondary_color']);
        $this->assertSame('#FFAA00', $branding['accent_color']);
        $this->assertArrayHasKey('primary_color_dark', $branding);
        $this->assertArrayHasKey('primary_color_light', $branding);
        $this->assertArrayHasKey('primary_color_glow', $branding);
        $this->assertArrayHasKey('secondary_color_light', $branding);

        $this
            ->get(route('donate'))
            ->assertOk()
            ->assertSee('--primary: #0055AA', false)
            ->assertSee('--secondary: #223344', false)
            ->assertSee('--accent: #FFAA00', false)
            ->assertSee('--primary-dark: ' . $branding['primary_color_dark'], false)
            ->assertSee('--primary-light: ' . $branding['primary_color_light'], false);
    }
}
