<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Agontara Foundation - Empowering communities, transforming lives through sustainable development and humanitarian aid.">
        <meta name="keywords" content="NGO, charity, donation, community development, humanitarian">
        
        <title>{{ config('app.name', 'Agontara Foundation') }} - Empowering Communities</title>

        @php
            $general = $siteSettings['general'] ?? [];
            $orgName = $general['org_name'] ?? config('app.name', 'BAF');
            $tagline = $general['tagline'] ?? 'Honoring Legacy, Building Hope';
            $heroCopy = $general['about_short'] ?? '';
            $favicon = $siteBranding['favicon'] ?? '/images/favicon.png';
            $primary = $siteBranding['primary_color_hex'] ?? $siteBranding['primary_color'] ?? '#F53003';
            $primaryDark = $siteBranding['primary_color_dark'] ?? $siteBranding['primary_color'] ?? '#D42000';
            $primaryLight = $siteBranding['primary_color_light'] ?? $siteBranding['primary_color'] ?? '#FF6347';
            $secondary = $siteBranding['secondary_color_hex'] ?? $siteBranding['secondary_color'] ?? '#1B1B18';
            $accent = $siteBranding['accent_color_hex'] ?? $siteBranding['accent_color'] ?? '#F8B803';
            $hexToRgb = static function (string $hex): array {
                $hex = ltrim($hex, '#');
                return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
            };
            $rgbString = static function (string $hex) use ($hexToRgb): string {
                return implode(', ', $hexToRgb($hex));
            };
            $contrastColor = static function (string $hex) use ($hexToRgb): string {
                [$red, $green, $blue] = $hexToRgb($hex);
                $luminance = (($red * 299) + ($green * 587) + ($blue * 114)) / 1000;
                return $luminance > 155 ? '#111827' : '#FFFFFF';
            };
            $primaryContrast = $contrastColor($primary);
            $secondaryContrast = $contrastColor($secondary);
            $cmsImage = fn ($path, $fallback) => $path ? (str_starts_with($path, 'http') ? $path : asset('storage/' . ltrim($path, '/'))) : $fallback;
            $heroTitle = $hero?->title ?: $tagline;
            $heroDescription = $hero?->description ?: $heroCopy;
            $heroButtonText = $hero?->button_text ?: 'Donate Now';
            $heroButtonLink = $hero?->button_link ?: route('donate');
        @endphp
        <link rel="icon" href="{{ $favicon }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- AOS Animation -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        
        <!-- Lightbox for Gallery -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">

        <style>
            :root {
                --primary: {{ $primary }};
                --primary-dark: {{ $primaryDark }};
                --primary-light: {{ $primaryLight }};
                --secondary: {{ $secondary }};
                --accent: {{ $accent }};
                --primary-rgb: {{ $rgbString($primary) }};
                --secondary-rgb: {{ $rgbString($secondary) }};
                --primary-contrast: {{ $primaryContrast }};
                --secondary-contrast: {{ $secondaryContrast }};
                --text-dark: #172033;
                --text-light: #526174;
                --bg-light: #F8FAFC;
                --surface: #FFFFFF;
                --surface-muted: #F1F5F9;
                --bg-dark: #0a0a0a;
                --white: #ffffff;
                --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                --gradient-light: linear-gradient(135deg, rgba(var(--primary-rgb), 0.12) 0%, rgba(var(--secondary-rgb), 0.07) 100%);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background: var(--bg-light);
                color: var(--text-dark);
                overflow-x: hidden;
            }

            /* Navigation */
            .navbar {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
                position: fixed;
                width: 100%;
                top: 0;
                z-index: 1000;
                transition: all 0.3s ease;
            }

            .navbar.scrolled {
                background: white;
                box-shadow: 0 2px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-container {
                max-width: 1280px;
                margin: 0 auto;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--primary);
                text-decoration: none;
            }

            .logo span {
                color: var(--secondary);
            }

            .nav-links {
                display: flex;
                gap: 2rem;
                align-items: center;
            }

            .nav-links a {
                text-decoration: none;
                color: var(--text-dark);
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .nav-links a:hover {
                color: var(--primary);
            }

            .donate-btn {
                background: var(--gradient);
                color: var(--primary-contrast) !important;
                padding: 0.5rem 1.5rem;
                border-radius: 50px;
                transition: transform 0.3s ease !important;
            }

            .donate-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.3);
            }

            .mobile-menu {
                display: none;
                font-size: 1.5rem;
                cursor: pointer;
            }

            /* Hero Section */
            .hero {
                min-height: 100vh;
                background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08) 0%, rgba(var(--secondary-rgb), 0.04) 100%);
                display: flex;
                align-items: center;
                padding-top: 80px;
            }

            .hero-container {
                max-width: 1280px;
                margin: 0 auto;
                padding: 4rem 2rem;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                align-items: center;
            }

            .hero-content h1 {
                font-size: 3.5rem;
                font-weight: 700;
                line-height: 1.2;
                margin-bottom: 1.5rem;
                background: var(--gradient);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .hero-content p {
                font-size: 1.125rem;
                color: var(--text-light);
                line-height: 1.6;
                margin-bottom: 2rem;
            }

            .hero-buttons {
                display: flex;
                gap: 1rem;
            }

            .btn-primary {
                background: var(--gradient);
                color: var(--primary-contrast);
                padding: 0.875rem 2rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(var(--primary-rgb), 0.2);
            }

            .btn-secondary {
                background: transparent;
                color: var(--primary);
                padding: 0.875rem 2rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                border: 2px solid var(--primary);
                transition: all 0.3s ease;
            }

            .btn-secondary:hover {
                background: var(--primary);
                color: white;
            }

            .hero-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
                margin-top: 3rem;
            }

            .stat-item h3 {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary);
            }

            .stat-item p {
                font-size: 0.875rem;
                margin: 0;
            }

            .hero-image img {
                width: 100%;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            /* Sections Common */
            .section {
                padding: 5rem 2rem;
            }

            .section-container {
                max-width: 1280px;
                margin: 0 auto;
            }

            .section-title {
                text-align: center;
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .section-subtitle {
                text-align: center;
                color: var(--text-light);
                margin-bottom: 3rem;
                font-size: 1.125rem;
            }

            /* Mission Vision Values */
            .mvv-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                margin-top: 2rem;
            }

            .mvv-card {
                text-align: center;
                padding: 2rem;
                background: white;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease;
            }

            .mvv-card:hover {
                transform: translateY(-5px);
            }

            .mvv-icon {
                width: 80px;
                height: 80px;
                background: var(--gradient-light);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
            }

            .mvv-icon i {
                font-size: 2rem;
                color: var(--primary);
            }

            .mvv-card h3 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .mvv-card p {
                color: var(--text-light);
                line-height: 1.6;
            }

            /* Values List */
            .values-list {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-top: 2rem;
            }

            .value-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                background: var(--bg-light);
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .value-item:hover {
                background: white;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transform: translateX(5px);
            }

            .value-icon {
                width: 50px;
                height: 50px;
                background: var(--gradient);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            .value-content h4 {
                font-weight: 700;
                margin-bottom: 0.25rem;
            }

            .value-content p {
                font-size: 0.875rem;
                color: var(--text-light);
            }

            /* Info/Ads Cards */
            .info-cards {
                background: var(--gradient-light);
            }

            .cards-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }

            .info-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                position: relative;
            }

            .info-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            }

            .card-badge {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: var(--primary);
                color: white;
                padding: 0.25rem 1rem;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 600;
                z-index: 1;
            }

            .card-image {
                height: 200px;
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .card-content {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .card-description {
                color: var(--text-light);
                line-height: 1.5;
                margin-bottom: 1rem;
            }

            .card-link {
                color: var(--primary);
                text-decoration: none;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .card-link:hover {
                gap: 0.75rem;
            }

            /* Projects Grid */
            .projects-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
            }

            .project-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease;
            }

            .project-card:hover {
                transform: translateY(-10px);
            }

            .project-image {
                height: 250px;
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .project-category {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: var(--primary);
                color: white;
                padding: 0.25rem 1rem;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .project-content {
                padding: 1.5rem;
            }

            .project-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .project-description {
                color: var(--text-light);
                line-height: 1.5;
                margin-bottom: 1rem;
            }

            .progress-bar {
                background: #f0f0f0;
                height: 8px;
                border-radius: 10px;
                overflow: hidden;
                margin: 1rem 0;
            }

            .progress-fill {
                background: var(--gradient);
                height: 100%;
                width: 0%;
                transition: width 0.5s ease;
            }

            .project-stats {
                display: flex;
                justify-content: space-between;
                margin-bottom: 1rem;
                font-size: 0.875rem;
            }

            .project-stats span:first-child {
                font-weight: 600;
                color: var(--primary);
            }

            /* Gallery */
            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .gallery-item {
                position: relative;
                overflow: hidden;
                border-radius: 15px;
                cursor: pointer;
            }

            .gallery-item img {
                width: 100%;
                height: 250px;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .gallery-item:hover img {
                transform: scale(1.1);
            }

            .gallery-overlay {
                position: absolute;
                bottom: -100%;
                left: 0;
                right: 0;
                background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
                color: white;
                padding: 1rem;
                transition: bottom 0.3s ease;
            }

            .gallery-item:hover .gallery-overlay {
                bottom: 0;
            }

            /* Blog/News Section */
            .blog-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
            }

            .blog-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .blog-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .blog-image {
                height: 200px;
                background-size: cover;
                background-position: center;
            }

            .blog-content {
                padding: 1.5rem;
            }

            .blog-meta {
                display: flex;
                gap: 1rem;
                margin-bottom: 0.75rem;
                font-size: 0.75rem;
                color: var(--primary);
                font-weight: 600;
            }

            .blog-title {
                font-size: 1.125rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                line-height: 1.4;
            }

            .blog-excerpt {
                color: var(--text-light);
                line-height: 1.5;
                margin-bottom: 1rem;
            }

            .read-more {
                color: var(--primary);
                text-decoration: none;
                font-weight: 600;
                font-size: 0.875rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Team Section */
            .team-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
            }

            .team-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                text-align: center;
            }

            .team-card:hover {
                transform: translateY(-10px);
            }

            .team-image {
                width: 100%;
                height: 300px;
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .team-social {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
                padding: 1rem;
                display: flex;
                justify-content: center;
                gap: 1rem;
                transform: translateY(100%);
                transition: transform 0.3s ease;
            }

            .team-card:hover .team-social {
                transform: translateY(0);
            }

            .team-social a {
                width: 35px;
                height: 35px;
                background: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary);
                transition: all 0.3s ease;
            }

            .team-social a:hover {
                background: var(--primary);
                color: white;
                transform: scale(1.1);
            }

            .team-info {
                padding: 1.5rem;
            }

            .team-name {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0.25rem;
            }

            .team-role {
                color: var(--primary);
                font-weight: 600;
                margin-bottom: 0.5rem;
            }

            .team-bio {
                color: var(--text-light);
                font-size: 0.875rem;
                line-height: 1.5;
            }

            .founder-badge {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: var(--accent);
                color: var(--secondary);
                padding: 0.25rem 1rem;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 700;
                z-index: 1;
            }

            /* Impact Stats */
            .impact-section {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
            }

            .impact-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 3rem;
                text-align: center;
            }

            .impact-item h2 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .impact-item p {
                font-size: 1rem;
                opacity: 0.9;
            }

            /* Events */
            .events-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }

            .event-card {
                display: flex;
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            }

            .event-date {
                background: var(--primary);
                color: white;
                padding: 1rem;
                text-align: center;
                min-width: 100px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .event-date .day {
                font-size: 2rem;
                font-weight: 700;
                line-height: 1;
            }

            .event-date .month {
                font-size: 0.875rem;
            }

            .event-details {
                padding: 1rem;
                flex: 1;
            }

            .event-title {
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .event-location {
                color: var(--text-light);
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
            }

            /* Testimonials */
            .testimonials-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
            }

            .testimonial-card {
                background: white;
                padding: 2rem;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
                position: relative;
            }

            .testimonial-card:before {
                content: '"';
                position: absolute;
                top: 1rem;
                left: 1.5rem;
                font-size: 4rem;
                color: var(--primary);
                opacity: 0.2;
                font-family: serif;
            }

            .testimonial-text {
                font-style: italic;
                margin-bottom: 1rem;
                line-height: 1.6;
            }

            .testimonial-author {
                font-weight: 700;
                color: var(--primary);
            }

            /* Volunteer Registration Horizontal Card */
            .volunteer-horizontal {
                background: white;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                gap: 2rem;
                margin: 3rem 0;
                transition: transform 0.3s ease;
            }

            .volunteer-horizontal:hover {
                transform: translateY(-5px);
            }

            .volunteer-image {
                flex: 1;
                min-height: 300px;
                background-size: cover;
                background-position: center;
            }

            .volunteer-content {
                flex: 1.5;
                padding: 2rem 2rem 2rem 0;
            }

            .volunteer-content h3 {
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 1rem;
                color: var(--primary);
            }

            .volunteer-content p {
                color: var(--text-light);
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }

            .volunteer-content .btn-volunteer {
                background: var(--gradient);
                color: white;
                padding: 0.875rem 2rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.3s ease;
            }

            .volunteer-content .btn-volunteer:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(245, 48, 3, 0.3);
                gap: 0.75rem;
            }

            /* Partners & Sponsors Section - Horizontal Logo Showcase */
            .partners-section {
                background: var(--bg-light);
                padding: 4rem 2rem;
                text-align: center;
            }

            .partners-container {
                max-width: 1280px;
                margin: 0 auto;
            }

            .partners-title {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .partners-subtitle {
                color: var(--text-light);
                margin-bottom: 3rem;
            }

            .partners-logos {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                gap: 3rem;
            }

            .partner-logo {
                flex: 0 0 auto;
                text-align: center;
                transition: all 0.3s ease;
                filter: grayscale(100%);
                opacity: 0.7;
            }

            .partner-logo:hover {
                filter: grayscale(0%);
                opacity: 1;
                transform: scale(1.05);
            }

            .partner-logo img {
                max-width: 140px;
                height: auto;
                max-height: 80px;
                object-fit: contain;
            }

            .partner-logo p {
                margin-top: 0.5rem;
                font-size: 0.75rem;
                color: var(--text-light);
                font-weight: 500;
            }

            .partner-logo small {
                display: block;
                color: var(--text-light);
                font-size: 0.7rem;
                line-height: 1.4;
                max-width: 180px;
            }

            .partners-empty {
                color: var(--text-light);
                margin: 0;
            }

            /* CTA Section */
            .cta-section {
                background: linear-gradient(135deg, var(--secondary) 0%, #2a2a28 100%);
                color: white;
                text-align: center;
            }

            .cta-section h2 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .cta-section p {
                margin-bottom: 2rem;
                opacity: 0.9;
            }

            /* Footer */
            .footer {
                background: var(--secondary);
                color: white;
                padding: 4rem 2rem 2rem;
            }

            .footer-container {
                max-width: 1280px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 3rem;
            }

            .footer-col h4 {
                margin-bottom: 1.5rem;
                font-size: 1.125rem;
            }

            .footer-col p {
                color: #a0a0a0;
                line-height: 1.6;
            }

            .footer-col ul {
                list-style: none;
            }

            .footer-col ul li {
                margin-bottom: 0.75rem;
            }

            .footer-col ul li a {
                color: #a0a0a0;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .footer-col ul li a:hover {
                color: var(--primary);
            }

            .social-links {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
            }

            .social-links a {
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .social-links a:hover {
                background: var(--primary);
                transform: translateY(-3px);
            }

            .footer-bottom {
                text-align: center;
                padding-top: 3rem;
                margin-top: 3rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                color: #a0a0a0;
            }

            /* Program Cards Hover Effect */
.program-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

/* Donation Impact Cards */
.donation-impact-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

/* Get Involved Cards */
.get-involved-card:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-5px);
}

/* Newsletter Input Focus */
.newsletter-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.1);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .newsletter-form {
        flex-direction: column;
        padding: 0 1rem;
    }
    
    .newsletter-form input,
    .newsletter-form button {
        width: 100%;
    }
}

            /* Responsive */
            @media (max-width: 768px) {
                .mobile-menu {
                    display: block;
                }

                .nav-links {
                    position: fixed;
                    top: 70px;
                    left: -100%;
                    width: 100%;
                    height: calc(100vh - 70px);
                    background: white;
                    flex-direction: column;
                    padding: 2rem;
                    transition: left 0.3s ease;
                }

                .nav-links.active {
                    left: 0;
                }

                .hero-container {
                    grid-template-columns: 1fr;
                    text-align: center;
                }

                .hero-content h1 {
                    font-size: 2.5rem;
                }

                .hero-buttons {
                    justify-content: center;
                }

                .hero-stats {
                    justify-content: center;
                }

                .section-title {
                    font-size: 2rem;
                }

                .projects-grid,
                .testimonials-grid,
                .blog-grid,
                .gallery-grid,
                .team-grid,
                .mvv-grid {
                    grid-template-columns: 1fr;
                }

                .event-card {
                    flex-direction: column;
                }

                .event-date {
                    flex-direction: row;
                    justify-content: center;
                    gap: 0.5rem;
                    padding: 0.5rem;
                }

                .volunteer-horizontal {
                    flex-direction: column;
                }

                .volunteer-image {
                    width: 100%;
                    min-height: 250px;
                }

                .volunteer-content {
                    padding: 2rem;
                    text-align: center;
                }

                .partners-logos {
                    gap: 1.5rem;
                }

                .partner-logo img {
                    max-width: 100px;
                }
            }

            /* Add responsive CSS for about section */

            @media (max-width: 768px) {
                .about-grid {
                    grid-template-columns: 1fr !important;
                }
            }


            <style>
    /* Memorial Banner Section */
    .impact-section {
        background: linear-gradient(135deg, var(--secondary) 0%, #0a0a0a 100%);
        padding: 3rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .impact-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 10% 50%, rgba(245, 48, 3, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 90% 50%, rgba(245, 48, 3, 0.08) 0%, transparent 50%);
        pointer-events: none;
    }

    .impact-section:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="90" opacity="0.03">✝</text></svg>') repeat;
        background-size: 60px 60px;
        pointer-events: none;
    }

    .memorial-banner {
        max-width: 1200px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .memorial-banner:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        border-color: rgba(245, 48, 3, 0.2);
        background: rgba(255, 255, 255, 0.05);
    }

    /* Left Side */
    .banner-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex: 1;
    }

    .banner-icon {
        width: 65px;
        height: 65px;
        min-width: 65px;
        background: var(--gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        animation: pulseGlow 2.5s ease-in-out infinite;
        position: relative;
        flex-shrink: 0;
    }

    .banner-icon:before {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 50%;
        border: 2px solid rgba(245, 48, 3, 0.15);
        animation: ringPulse 2.5s ease-in-out infinite;
    }

    @keyframes pulseGlow {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(245, 48, 3, 0.3);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 20px rgba(245, 48, 3, 0);
        }
    }

    @keyframes ringPulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.4);
            opacity: 0;
        }
    }

    .banner-text h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.25rem;
        letter-spacing: 0.5px;
    }

    .banner-text p {
        font-size: 1rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
    }

    .banner-text .highlight {
        color: var(--accent);
        font-weight: 600;
    }

    /* Right Side */
    .banner-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .banner-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--gradient);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .banner-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.5s ease;
    }

    .banner-btn:hover:before {
        left: 100%;
    }

    .banner-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(245, 48, 3, 0.3);
        gap: 1rem;
    }

    .legacy-tag {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.3);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 300;
    }

    .legacy-tag:before,
    .legacy-tag:after {
        content: '•';
        margin: 0 0.5rem;
        color: var(--primary);
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .memorial-banner {
            flex-direction: column;
            align-items: stretch;
            padding: 1.75rem;
            gap: 1.5rem;
        }

        .banner-left {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .banner-right {
            align-items: center;
            gap: 0.75rem;
        }

        .banner-text p {
            text-align: center;
        }

        .banner-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .impact-section {
            padding: 2rem 1rem;
        }

        .memorial-banner {
            padding: 1.5rem;
            border-radius: 15px;
        }

        .banner-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            font-size: 1.5rem;
        }

        .banner-text h3 {
            font-size: 1rem;
        }

        .banner-text p {
            font-size: 0.9rem;
        }

        .banner-btn {
            font-size: 0.875rem;
            padding: 0.7rem 1.5rem;
        }

        .legacy-tag {
            font-size: 0.6rem;
        }
    }

    /* Optional: Add a subtle animated border glow */
    .memorial-banner::after {
        content: '';
        position: absolute;
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        border-radius: 20px;
        background: linear-gradient(135deg, transparent 30%, var(--primary) 50%, transparent 70%);
        background-size: 200% 200%;
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: -1;
        animation: borderGlow 3s ease-in-out infinite;
    }

    .memorial-banner:hover::after {
        opacity: 0.3;
    }

    @keyframes borderGlow {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    /* Keep legacy inline section colors readable with any configured branding. */
    .info-card,
    .project-card,
    .blog-card,
    .team-card,
    .event-card,
    .testimonial-card,
    .mvv-card,
    .donation-impact-card {
        background: var(--surface);
        color: var(--text-dark);
    }

    .section[style*="#f9f9f9"] {
        background: var(--surface-muted) !important;
    }

    .impact-section,
    .cta-section,
    .footer {
        background: var(--secondary);
        background: linear-gradient(135deg, var(--secondary) 0%, color-mix(in srgb, var(--secondary) 78%, #000 22%) 100%);
        color: var(--secondary-contrast);
    }

    .impact-section .banner-text p,
    .impact-section .legacy-tag,
    .cta-section p,
    .footer-col p,
    .footer-col ul li a,
    .footer-bottom {
        color: var(--secondary-contrast);
        opacity: 0.86;
    }

    .impact-section .banner-text .highlight,
    .footer-col ul li a:hover {
        color: var(--accent);
        opacity: 1;
    }

    .banner-btn,
    .btn-primary {
        color: var(--primary-contrast);
    }

    .donation-impact-card p,
    .event-details p,
    .testimonial-text,
    .blog-excerpt,
    .project-description,
    .team-bio,
    .card-description,
    .section-subtitle,
    .partners-subtitle {
        color: var(--text-light);
    }
</style>

    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar" id="navbar">
            <div class="nav-container">
                <a href="/" class="logo">Agontara <span>Foundation</span></a>
                <div class="mobile-menu" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="nav-links" id="navLinks">
                    <a href="#home">Dashboard</a>
                    <a href="#about">About</a>
                    <a href="#mission-vision">Mission & Vision</a>
                    <a href="#projects">Projects</a>
                    <a href="#gallery">Gallery</a>
                    <a href="{{ route('heritage.index') }}">Heritage</a>
                   <a href="{{ route('blog.index') }}">News</a>
                    <a href="{{ route('team') }}">Team</a>
                    <a href="{{ route('board') }}">Board</a>
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="{{ route('donate') }}" class="donate-btn">Donate Now</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="hero-container">
                <div class="hero-content" data-aos="fade-right">
                    <h1>{{ $heroTitle }}</h1>
                    <p>{{ $heroDescription }}</p>
                    <div class="hero-buttons">
                        <a href="{{ $heroButtonLink }}" class="btn-primary">
                            <i class="fas fa-heart"></i> {{ $heroButtonText }}
                        </a>
                        <a href="{{ $hero?->metadata['secondary_button_link'] ?? route('about') }}" class="btn-secondary">
                            {{ $hero?->metadata['secondary_button_text'] ?? 'Learn More' }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="hero-stats">
                        @forelse($impactLevels as $impact)
                            <div class="stat-item"><h3>{{ $impact->level }}</h3><p>{{ $impact->title }}</p></div>
                        @empty
                            <div class="stat-item"><h3>{{ $projects->count() }}</h3><p>Active Projects</p></div>
                        @endforelse
                    </div>
                </div>
                <div class="hero-image" data-aos="fade-left">
                    <img src="{{ $cmsImage($hero?->image, 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&h=400&fit=crop') }}" alt="{{ $heroTitle }}">
                </div>
            </div>
        </section>



        <!-- Mission, Vision & Values Section -->
        <section class="section" id="mission-vision">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">{{ $mission?->section?->name ?? 'About BAF' }}</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $mission?->subtitle ?? 'Guiding principles that drive our mission forward' }}</p>
                
                <div class="mvv-grid">
                    @if($mission)
                    <div class="mvv-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="mvv-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>{{ $mission->title }}</h3>
                        <p>{{ $mission->description }}</p>
                    </div>
                    @endif
                    @if($vision)
                    <div class="mvv-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="mvv-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>{{ $vision->title }}</h3>
                        <p>{{ $vision->description }}</p>
                    </div>
                    @endif
                    <div class="mvv-card" data-aos="fade-up" data-aos-delay="250">
                        <div class="mvv-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Core Values</h3>
                        <p>{{ $values->isNotEmpty() ? $values->pluck('title')->implode(', ') : 'Compassion, integrity, empowerment, and sustainable community impact.' }}</p>
                    </div>
                </div>

                <!-- Core Values List -->
                <div class="values-list" data-aos="fade-up" data-aos-delay="300">
                    @foreach($values as $value)
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="value-content">
                            <h4>{{ $value->title }}</h4>
                            <p>{{ $value->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Info/Ads Cards Section -->
        <section class="info-cards section">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Featured Initiatives</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $sections->get('info-cards')?->description }}</p>
                <div class="cards-grid">
                    @forelse($infoCards as $card)
                    <div class="info-card" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
                        @if($card->badge)<div class="card-badge">{{ $card->badge }}</div>@endif
                        <div class="card-image" style="background-image: url('{{ $cmsImage($card->image, 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop') }}')"></div>
                        <div class="card-content"><h3 class="card-title">{{ $card->title }}</h3><p class="card-description">{{ $card->description }}</p>@if($card->link_url)<a href="{{ $card->link_url }}" class="card-link">{{ $card->link_text ?: 'Learn More' }} <i class="fas fa-arrow-right"></i></a>@endif</div>
                    </div>
                    @empty
                    <p class="section-subtitle">Featured initiatives will appear here soon.</p>
                    @endforelse
                </div>
            </div>
        </section>

      
        <!-- VOLUNTEER REGISTRATION HORIZONTAL CARD SECTION -->
        @php
            $volunteerBlock = $sections->get('volunteer')?->contents->first();
        @endphp
        <section class="section" id="volunteer">
            <div class="section-container">
                <div class="volunteer-horizontal" data-aos="fade-up">
                    <div class="volunteer-image" style="background-image: url('{{ $cmsImage($volunteerBlock?->image ?? null, 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600&h=400&fit=crop') }}');"></div>
                    <div class="volunteer-content">
                        <h3>{{ $volunteerBlock?->title ?? 'Become a Volunteer' }}</h3>
                        <p>{{ $volunteerBlock?->description }}</p>
                        <a href="{{ $volunteerBlock?->button_link ?? route('volunteer') }}" class="btn-volunteer">
                            <i class="fas fa-hands-helping"></i> {{ $volunteerBlock?->button_text ?? 'Register as a Volunteer' }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section class="section" id="projects">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">{{ $sections->get('projects')?->name }}</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $sections->get('projects')?->description }}</p>
                <div class="projects-grid">
                    @foreach($projects as $project)
                    @php
                        $raised = min((float) ($project->raised_total ?? 0), (float) $project->goal_amount);
                        $progress = $project->goal_amount > 0 ? min(($raised / (float) $project->goal_amount) * 100, 100) : 0;
                    @endphp
                    <div class="project-card" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
                        <div class="project-image" style="background-image: url('{{ $cmsImage($project->image, 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=250&fit=crop') }}')">
                            <span class="project-category">{{ $project->tag ?: $project->location }}</span>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">{{ $project->title }}</h3>
                            <p class="project-description">{{ $project->description }}</p>
                            <div class="project-stats">
                                <span>{{ number_format($raised, 2) }} raised</span>
                                <span>Goal: {{ number_format($project->goal_amount, 2) }}</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $progress }}%"></div>
                            </div>
                            <a href="{{ route('donate', ['project_id' => $project->id]) }}" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Donate Now</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- Memorial Banner/Notice Section - Horizontal -->
        @php
            $memorialBlock = $sections->get('memorial-banner')?->contents->first();
        @endphp
<section class="impact-section section" id="memorial-banner">
    <div class="section-container">
        <div class="memorial-banner" data-aos="fade-up">
            <div class="banner-left">
                <div class="banner-icon">
                    <i class="fas fa-cross"></i>
                </div>
                <div class="banner-text">
                    <h3>{{ $memorialBlock?->title }}</h3>
                    <p>
                        {{ $memorialBlock?->description }}
                    </p>
                </div>
            </div>
            <div class="banner-right">
                <a href="{{ $memorialBlock?->button_link ?? '#donate' }}" class="banner-btn">
                    <i class="fas fa-hand-holding-heart"></i> {{ $memorialBlock?->button_text ?? 'Continue His Mission' }}
                </a>
                <span class="legacy-tag">{{ $memorialBlock?->subtitle ?? 'His Legacy Lives On' }}</span>
            </div>
        </div>
    </div>
</section>


        <!-- Gallery Section -->
        <section class="section" id="gallery" style="background: #f9f9f9;">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Our Gallery</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Moments that matter</p>
                <div class="gallery-grid">
                    @foreach($galleryItems as $item)
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
                        <a href="{{ $cmsImage($item->image, '') }}" data-lightbox="gallery">
                            <img src="{{ $cmsImage($item->image, '') }}" alt="{{ $item->title }}">
                            <div class="gallery-overlay"><p>{{ $item->caption ?: $item->title }}</p></div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


          

<!-- Donation Impact Section - Add after Projects or before Gallery -->
<section class="section" id="donate-impact" style="background: var(--gradient-light);">
    <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">{{ $sections->get('donate-impact')?->name }}</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $sections->get('donate-impact')?->description }}</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            @foreach($sections->get('donate-impact')?->contents ?? collect() as $impact)
            <div class="donation-impact-card" data-aos="flip-up" data-aos-delay="{{ 150 + ($loop->index * 50) }}" style="background: white; border-radius: 15px; padding: 2rem; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.05);"><div style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"><i class="fas {{ $impact->metadata['icon'] ?? 'fa-heart' }}"></i></div><h3 style="font-size: 2rem; font-weight: 800; color: var(--primary);">{{ $impact->metadata['amount'] ?? '' }}</h3><p style="color: var(--text-light); font-weight: 600;">{{ $impact->description }}</p></div>
            @endforeach
        </div>
    </div>
</section>


        <!-- Recent Blog/News Section -->
        <section class="section" id="blog">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Recent News & Stories</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Stay updated with our latest impact stories</p>
                <div class="blog-grid">
                    @foreach($blogPosts as $post)
                    <div class="blog-card" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
                        <div class="blog-image" style="background-image: url('{{ $cmsImage($post->featured_image, 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop') }}')"></div>
                        <div class="blog-content">
                            <div class="blog-meta"><span><i class="far fa-calendar-alt"></i> {{ $post->formatted_date }}</span><span><i class="far fa-user"></i> {{ $post->author }}</span></div>
                            <h3 class="blog-title">{{ $post->title }}</h3>
                            <p class="blog-excerpt">{{ $post->excerpt }}</p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="section" id="team" style="background: #f9f9f9;">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Our Leadership Team</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Meet the people behind our mission</p>
                <div class="team-grid">
                    @if($teamMembers->isNotEmpty())
                    @foreach($teamMembers as $member)
                    <div class="team-card" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
                        <div class="team-image" style="background-image: url('{{ $cmsImage($member->image, 'https://randomuser.me/api/portraits/men/32.jpg') }}')">
                            @if($member->is_founder)<div class="founder-badge">Founder</div>@endif
                            <div class="team-social">@foreach(($member->social_links ?? []) as $network => $url)<a href="{{ $url }}"><i class="fab fa-{{ $network }}"></i></a>@endforeach</div>
                        </div>
                        <div class="team-info"><h3 class="team-name">{{ $member->name }}</h3><p class="team-role">{{ $member->role }}</p><p class="team-bio">{{ $member->bio }}</p></div>
                    </div>
                    @endforeach
                    @else
                    <p class="section-subtitle">Team profiles will appear here once they are published.</p>
                    {{--
                    <div class="team-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="team-image" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg')">
                            <div class="founder-badge">Founder & CEO</div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Dr. James Wilson</h3>
                            <p class="team-role">Founder & Executive Director</p>
                            <p class="team-bio">With over 20 years of experience in international development, Dr. Wilson founded Agontara Foundation to create lasting change.</p>
                        </div>
                    </div>
                    <div class="team-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="team-image" style="background-image: url('https://randomuser.me/api/portraits/women/68.jpg')">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Sarah Martinez</h3>
                            <p class="team-role">Programs Director</p>
                            <p class="team-bio">Sarah oversees all our field programs, ensuring maximum impact and efficient resource utilization.</p>
                        </div>
                    </div>
                    <div class="team-card" data-aos="fade-up" data-aos-delay="250">
                        <div class="team-image" style="background-image: url('https://randomuser.me/api/portraits/men/45.jpg')">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Michael Chen</h3>
                            <p class="team-role">Operations Manager</p>
                            <p class="team-bio">Michael ensures our day-to-day operations run smoothly, from logistics to volunteer coordination.</p>
                        </div>
                    </div>
                    <div class="team-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="team-image" style="background-image: url('https://randomuser.me/api/portraits/women/89.jpg')">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Dr. Amara Okonkwo</h3>
                            <p class="team-role">Medical Director</p>
                            <p class="team-bio">Dr. Okonkwo leads our healthcare initiatives, bringing quality medical care to underserved communities.</p>
                        </div>
                    </div>
                    --}}
                    @endif
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section class="section" id="events">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Upcoming Events</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Get involved and make a difference</p>
                <div class="events-grid">
                    @if($events->isNotEmpty())
                    @foreach($events as $event)
                    <div class="event-card" data-aos="fade-up">
                        <div class="event-date"><span class="day">{{ $event->event_date->format('d') }}</span><span class="month">{{ $event->event_date->format('M') }}</span></div>
                        <div class="event-details"><h3 class="event-title">{{ $event->title }}</h3><p class="event-location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p><p style="font-size:.875rem;color:var(--text-light);">{{ $event->description }}</p></div>
                    </div>
                    @endforeach
                    @else
                    <p class="section-subtitle">Upcoming events will appear here once they are published.</p>
                    {{--
                    <div class="event-card" data-aos="fade-right">
                        <div class="event-date">
                            <span class="day">15</span>
                            <span class="month">MAR</span>
                        </div>
                        <div class="event-details">
                            <h3 class="event-title">Charity Gala Dinner</h3>
                            <p class="event-location"><i class="fas fa-map-marker-alt"></i> Grand Hall, City Center</p>
                            <p style="font-size: 0.875rem; color: var(--text-light);">Join us for an evening of fundraising and celebration</p>
                        </div>
                    </div>

                    <div class="event-card" data-aos="fade-left">
                        <div class="event-date">
                            <span class="day">22</span>
                            <span class="month">MAR</span>
                        </div>
                        <div class="event-details">
                            <h3 class="event-title">Volunteer Training Day</h3>
                            <p class="event-location"><i class="fas fa-map-marker-alt"></i> Community Center</p>
                            <p style="font-size: 0.875rem; color: var(--text-light);">Learn how you can contribute to our mission</p>
                        </div>
                    </div>

                    <div class="event-card" data-aos="fade-up">
                        <div class="event-date">
                            <span class="day">05</span>
                            <span class="month">APR</span>
                        </div>
                        <div class="event-details">
                            <h3 class="event-title">Virtual Fundraising Marathon</h3>
                            <p class="event-location"><i class="fas fa-globe"></i> Online Event</p>
                            <p style="font-size: 0.875rem; color: var(--text-light);">Join from anywhere in the world</p>
                        </div>
                    </div>
                    --}}
                    @endif
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="section" style="background: #f9f9f9;">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">What People Say</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Stories of impact and transformation</p>
                <div class="testimonials-grid">
                    @if($testimonials->isNotEmpty())
                    @foreach($testimonials as $testimonial)
                    <div class="testimonial-card" data-aos="fade-up"><p class="testimonial-text">"{{ $testimonial->testimonial }}"</p><p class="testimonial-author">- {{ $testimonial->author_name }}{{ $testimonial->role ? ', ' . $testimonial->role : '' }}</p></div>
                    @endforeach
                    @else
                    <p class="section-subtitle">Testimonials will appear here once they are published.</p>
                    {{--
                    <div class="testimonial-card" data-aos="fade-up">
                        <p class="testimonial-text">"Agontara Foundation transformed our community by providing clean water. Now our children don't have to walk miles every day."</p>
                        <p class="testimonial-author">- Sarah Johnson, Community Leader</p>
                    </div>
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                        <p class="testimonial-text">"Thanks to their education program, I was able to complete my studies and now I'm giving back to my community."</p>
                        <p class="testimonial-author">- Michael Omondi, Scholarship Recipient</p>
                    </div>
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                        <p class="testimonial-text">"Volunteering with Agontara has been the most rewarding experience of my life. Highly recommended!"</p>
                        <p class="testimonial-author">- Emily Chen, Volunteer</p>
                    </div>
                    --}}
                    @endif
                </div>
            </div>
        </section>

        <!-- PARTNERS & SPONSORS SECTION - HORIZONTAL LOGO SHOWCASE -->
        <section class="partners-section" id="partners">
            <div class="partners-container">
                <h2 class="partners-title" data-aos="fade-up">Our Partners & Sponsors</h2>
                <p class="partners-subtitle" data-aos="fade-up" data-aos-delay="100">Together we create lasting impact</p>
                <div class="partners-logos" data-aos="fade-up" data-aos-delay="150">
                    @forelse($partners as $partner)
                    <div class="partner-logo">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }} logo">
                        <p>{{ $partner->name }}</p>
                        @if($partner->description)<small>{{ $partner->description }}</small>@endif
                    </div>
                    @empty
                    <p class="partners-empty">Partner logos will appear here once they are added.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        @php
            $ctaBlock = $sections->get('cta')?->contents->first();
        @endphp
        <section class="cta-section section" id="donate">
            <div class="section-container">
                <h2 data-aos="fade-up">{{ $ctaBlock?->title }}</h2>
                <p data-aos="fade-up" data-aos-delay="100">{{ $ctaBlock?->description }}</p>
                <a href="{{ $ctaBlock?->button_link ?? route('donate') }}" class="btn-primary" data-aos="zoom-in" style="background: white; color: var(--primary);">
                    <i class="fas fa-heart"></i> {{ $ctaBlock?->button_text ?? 'Donate Today' }}
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer" id="contact">
            <div class="footer-container">
                <div class="footer-col">
                    <h4>{{ $orgName }}</h4>
                    <p>{{ $general['about_short'] ?? 'Empowering communities through sustainable development and humanitarian aid since 2015.' }}</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Dashboard</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#mission-vision">Mission & Vision</a></li>
                        <li><a href="#projects">Our Projects</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#blog">News & Stories</a></li>
                        <li><a href="#team">Our Team</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#donate">Donate</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Get Involved</h4>
                    <ul>
                        <li><a href="#">Volunteer</a></li>
                        <li><a href="#">Partner With Us</a></li>
                        <li><a href="#">Corporate Sponsorship</a></li>
                        <li><a href="#">Career Opportunities</a></li>
                        <li><a href="#">Leave a Legacy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Charity Street, City, Country</li>
                        <li><i class="fas fa-phone"></i> +1 234 567 890</li>
                        <li><i class="fas fa-envelope"></i> info@agontara.org</li>
                        <li><i class="fas fa-clock"></i> Mon-Fri: 9AM - 6PM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Agontara Foundation. All rights reserved. | <a href="#" style="color: white;">Privacy Policy</a> | <a href="#" style="color: white;">Terms of Use</a> | <a href="#" style="color: white;">Cookie Policy</a></p>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Mobile menu toggle
            function toggleMenu() {
                const navLinks = document.getElementById('navLinks');
                navLinks.classList.toggle('active');
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Close mobile menu if open
                        document.getElementById('navLinks').classList.remove('active');
                    }
                });
            });

            // Progress bar animation on scroll
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progressBars = entry.target.querySelectorAll('.progress-fill');
                        progressBars.forEach(bar => {
                            const width = bar.style.width;
                            bar.style.width = width;
                        });
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.project-card').forEach(card => {
                observer.observe(card);
            });
        </script>
    </body>
</html>