<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $payload = Schema::hasTable('site_settings')
                ? (SiteSetting::first()?->payload ?? [])
                : [];

            $branding = $this->normalizeBranding($payload['branding'] ?? []);

            $view->with('siteSettings', $payload);
            $view->with('siteBranding', $branding);
        });
    }

    private function normalizeBranding(array $branding): array
    {
        foreach (['logo_light','logo_dark','favicon'] as $assetField) {
            if (! isset($branding[$assetField])) {
                continue;
            }

            $path = parse_url($branding[$assetField], PHP_URL_PATH) ?: $branding[$assetField];

            if (Str::startsWith($path, '/storage/')) {
                $branding[$assetField] = $path;
            }
        }

        $defaults = [
            'primary_color' => '#F53003',
            'secondary_color' => '#1B1B18',
            'accent_color' => '#F8B803',
        ];

        foreach ($defaults as $colorKey => $fallback) {
            $hexKey = $colorKey . '_hex';
            $color = $this->normalizeHexColor($branding[$hexKey] ?? $branding[$colorKey] ?? $fallback, $fallback);

            $branding[$colorKey] = $color;
            $branding[$hexKey] = $color;
        }

        $branding['primary_color_dark'] = $branding['primary_color_dark'] ?? $this->shadeHexColor($branding['primary_color'], -18);
        $branding['primary_color_light'] = $branding['primary_color_light'] ?? $this->shadeHexColor($branding['primary_color'], 18);
        $branding['primary_color_glow'] = $branding['primary_color_glow'] ?? $this->hexToRgba($branding['primary_color'], 0.2);
        $branding['secondary_color_light'] = $branding['secondary_color_light'] ?? $this->shadeHexColor($branding['secondary_color'], 14);

        return $branding;
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
}
