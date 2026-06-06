<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function update(Request $request, $section)
    {
        $data = $request->except(['_token', '_method', '_active_tab']);
        $assetFields = ['logo_light','logo_dark','favicon'];

        // Basic validation per-section
        $rules = [];
        if ($section === 'branding') {
            $rules = [
                'primary_color' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
                'primary_color_hex' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
                'secondary_color' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
                'secondary_color_hex' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
                'accent_color' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
                'accent_color_hex' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
                'logo_light' => ['nullable','file','mimes:jpg,jpeg,png,gif,webp','max:2048'],
                'logo_dark' => ['nullable','file','mimes:jpg,jpeg,png,gif,webp','max:2048'],
                'favicon' => ['nullable','file','mimes:ico,jpg,jpeg,png,gif,webp','max:1024'],
            ];
        }

        if ($section === 'general') {
            $rules = [
                'email' => ['nullable','email'],
                'org_name' => ['nullable','string','max:191'],
            ];
        }

        if ($section === 'payment') {
            $rules = [
                'stripe_enabled' => ['nullable'],
                'stripe_key' => ['nullable','string','max:255'],
                'stripe_secret' => ['nullable','string','max:255'],
                'stripe_webhook' => ['nullable','string','max:255'],
                'paypal_enabled' => ['nullable'],
                'paypal_client_id' => ['nullable','string','max:255'],
                'paypal_secret' => ['nullable','string','max:255'],
                'paypal_mode' => ['nullable', Rule::in(['sandbox','live'])],
                'paystack_enabled' => ['nullable'],
                'paystack_public_key' => ['nullable','string','max:255'],
                'paystack_secret_key' => ['nullable','string','max:255'],
                'paystack_callback_url' => ['nullable','url','max:255'],
                'paystack_webhook_url' => ['nullable','url','max:255'],
                'paystack_mode' => ['nullable', Rule::in(['test','live'])],
                'currency' => ['nullable', Rule::in(['USD','EUR','GBP','CAD','AUD','INR','NGN'])],
            ];
        }

        $request->validate($rules);

        $settings = SiteSetting::first();
        if (! $settings) {
            $settings = SiteSetting::create(['payload' => []]);
        }

        $payload = $settings->payload ?? [];
        $currentSection = $payload[$section] ?? [];

        // Handle file uploads for branding
        if ($section === 'branding') {
            foreach ($assetFields as $fileField) {
                unset($data[$fileField]);

                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $path = $file->storePublicly('settings', ['disk' => 'public']);
                    $this->deletePublicAsset($currentSection[$fileField] ?? null);

                    $data[$fileField] = '/storage/' . ltrim($path, '/');
                } elseif (isset($currentSection[$fileField])) {
                    $data[$fileField] = $this->normalizePublicAssetUrl($currentSection[$fileField]);
                }
            }

            $data = $this->normalizeBrandingColors($data, $currentSection);
        }

        $payload[$section] = $data;

        $settings->payload = $payload;
        $settings->save();

        return back()
            ->with('success', ucfirst($section) . ' settings saved successfully.')
            ->with('active_tab', $section);
    }

    public function edit()
    {
        $settings = SiteSetting::first();
        $payload = $settings->payload ?? [];
        $payload['branding'] = $this->normalizeBrandingAssets($payload['branding'] ?? []);

        return view('admin.settings', ['settings' => $payload]);
    }

    private function normalizeBrandingAssets(array $branding): array
    {
        foreach (['logo_light','logo_dark','favicon'] as $assetField) {
            if (isset($branding[$assetField])) {
                $branding[$assetField] = $this->normalizePublicAssetUrl($branding[$assetField]);
            }
        }

        return $branding;
    }

    private function normalizeBrandingColors(array $data, array $currentSection = []): array
    {
        $defaults = [
            'primary_color' => '#F53003',
            'secondary_color' => '#1B1B18',
            'accent_color' => '#F8B803',
        ];

        foreach ($defaults as $colorKey => $fallback) {
            $hexKey = $colorKey . '_hex';
            $color = $this->normalizeHexColor(
                $data[$hexKey] ?? $data[$colorKey] ?? $currentSection[$hexKey] ?? $currentSection[$colorKey] ?? $fallback,
                $fallback
            );

            $data[$colorKey] = $color;
            $data[$hexKey] = $color;
        }

        $data['primary_color_dark'] = $this->shadeHexColor($data['primary_color'], -18);
        $data['primary_color_light'] = $this->shadeHexColor($data['primary_color'], 18);
        $data['primary_color_glow'] = $this->hexToRgba($data['primary_color'], 0.2);
        $data['secondary_color_light'] = $this->shadeHexColor($data['secondary_color'], 14);

        return $data;
    }

    private function normalizeHexColor(?string $color, string $fallback): string
    {
        $color = is_string($color) ? trim($color) : '';

        if (! preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            $color = $fallback;
        }

        return strtoupper($color);
    }

    private function shadeHexColor(string $color, int $percent): string
    {
        $color = ltrim($color, '#');
        $amount = max(-100, min(100, $percent)) / 100;
        $channels = str_split($color, 2);

        $channels = array_map(function (string $channel) use ($amount): string {
            $value = hexdec($channel);
            $target = $amount < 0 ? 0 : 255;
            $adjusted = (int) round($value + (($target - $value) * abs($amount)));

            return str_pad(dechex(max(0, min(255, $adjusted))), 2, '0', STR_PAD_LEFT);
        }, $channels);

        return '#' . strtoupper(implode('', $channels));
    }

    private function hexToRgba(string $color, float $alpha): string
    {
        $color = ltrim($color, '#');

        return sprintf(
            'rgba(%d, %d, %d, %.2F)',
            hexdec(substr($color, 0, 2)),
            hexdec(substr($color, 2, 2)),
            hexdec(substr($color, 4, 2)),
            $alpha
        );
    }

    private function normalizePublicAssetUrl(?string $url): ?string
    {
        if (! $url) {
            return $url;
        }

        $path = parse_url($url, PHP_URL_PATH) ?: $url;

        return Str::startsWith($path, '/storage/') ? $path : $url;
    }

    private function deletePublicAsset(?string $url): void
    {
        if (! $url) {
            return;
        }

        $path = parse_url($url, PHP_URL_PATH) ?: $url;

        if (! Str::startsWith($path, '/storage/')) {
            return;
        }

        $path = Str::after($path, '/storage/');

        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
