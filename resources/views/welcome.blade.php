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
            $orgName = $general['org_name'] ?? config('app.name', 'Agontara Foundation');
            $tagline = $general['tagline'] ?? 'Empowering Communities, Transforming Lives';
            $heroCopy = $general['about_short'] ?? 'Agontara Foundation is dedicated to creating sustainable change through education, healthcare, and community development programs across the globe.';
            $favicon = $siteBranding['favicon'] ?? '/images/favicon.png';
            $primary = $siteBranding['primary_color_hex'] ?? $siteBranding['primary_color'] ?? '#F53003';
            $primaryDark = $siteBranding['primary_color_dark'] ?? $siteBranding['primary_color'] ?? '#D42000';
            $primaryLight = $siteBranding['primary_color_light'] ?? $siteBranding['primary_color'] ?? '#FF6347';
            $secondary = $siteBranding['secondary_color_hex'] ?? $siteBranding['secondary_color'] ?? '#1B1B18';
            $accent = $siteBranding['accent_color_hex'] ?? $siteBranding['accent_color'] ?? '#F8B803';
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
                --text-dark: #1B1B18;
                --text-light: #706F6C;
                --bg-light: #FDFDFC;
                --bg-dark: #0a0a0a;
                --white: #ffffff;
                --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                --gradient-light: linear-gradient(135deg, rgba(245, 48, 3, 0.1) 0%, rgba(212, 32, 0, 0.1) 100%);
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
                color: white !important;
                padding: 0.5rem 1.5rem;
                border-radius: 50px;
                transition: transform 0.3s ease !important;
            }

            .donate-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(245, 48, 3, 0.3);
            }

            .mobile-menu {
                display: none;
                font-size: 1.5rem;
                cursor: pointer;
            }

            /* Hero Section */
            .hero {
                min-height: 100vh;
                background: linear-gradient(135deg, rgba(245, 48, 3, 0.05) 0%, rgba(27, 27, 24, 0.02) 100%);
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
                color: white;
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
                box-shadow: 0 10px 25px rgba(245, 48, 3, 0.2);
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
                   <a href="{{ route('blog.index') }}">News</a>
                    <a href="#team">Team</a>
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="{{ route('donate') }}" class="donate-btn">Donate Now</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="hero-container">
                <div class="hero-content" data-aos="fade-right">
                    <h1>{{ $tagline }}</h1>
                    <p>{{ $heroCopy }}</p>
                    <div class="hero-buttons">
                        <a href="#donate" class="btn-primary">
                            <i class="fas fa-heart"></i> Donate Now
                        </a>
                        <a href="#about" class="btn-secondary">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <h3>50K+</h3>
                            <p>Lives Impacted</p>
                        </div>
                        <div class="stat-item">
                            <h3>25+</h3>
                            <p>Active Projects</p>
                        </div>
                        <div class="stat-item">
                            <h3>15+</h3>
                            <p>Countries Reached</p>
                        </div>
                    </div>
                </div>
                <div class="hero-image" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&h=400&fit=crop" alt="Helping hands">
                </div>
            </div>
        </section>

        <!-- Mission, Vision & Values Section -->
        <section class="section" id="mission-vision">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Our Compass</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Guiding principles that drive our mission forward</p>
                
                <div class="mvv-grid">
                    <div class="mvv-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="mvv-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p>To empower underserved communities through sustainable development initiatives, providing access to education, healthcare, and economic opportunities that create lasting positive change.</p>
                    </div>
                    <div class="mvv-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="mvv-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>Our Vision</h3>
                        <p>A world where every individual has the opportunity to thrive, with access to quality education, healthcare, and the resources needed to build a better future for themselves and their communities.</p>
                    </div>
                    <div class="mvv-card" data-aos="fade-up" data-aos-delay="250">
                        <div class="mvv-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Our Values</h3>
                        <p>Integrity, compassion, sustainability, transparency, and collaboration guide every decision we make and every action we take.</p>
                    </div>
                </div>

                <!-- Core Values List -->
                <div class="values-list" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="value-content">
                            <h4>Compassion</h4>
                            <p>We serve with empathy and understanding</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="value-content">
                            <h4>Sustainability</h4>
                            <p>Creating lasting, self-sufficient solutions</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="value-content">
                            <h4>Integrity</h4>
                            <p>Transparent and accountable operations</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="value-content">
                            <h4>Collaboration</h4>
                            <p>Working together for greater impact</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Info/Ads Cards Section -->
        <section class="info-cards section">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Featured Initiatives</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Discover how you can make a difference</p>
                <div class="cards-grid">
                    <div class="info-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="card-badge">Limited Time</div>
                        <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Double Your Impact!</h3>
                            <p class="card-description">For a limited time, every donation you make will be matched by our corporate partners. Your $50 becomes $100!</p>
                            <a href="#" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-badge">New Program</div>
                        <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=200&fit=crop')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Become a Monthly Donor</h3>
                            <p class="card-description">Join our monthly giving program and provide sustainable support to communities in need. Start from just $10/month.</p>
                            <a href="#" class="card-link">Join Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="info-card" data-aos="fade-up" data-aos-delay="250">
                        <div class="card-badge">Volunteer</div>
                        <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1559027615-82f7d295a4f6?w=400&h=200&fit=crop')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Volunteer Abroad Program</h3>
                            <p class="card-description">Join our international volunteer program and make a direct impact in communities across Africa and Asia.</p>
                            <a href="#" class="card-link">Apply Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VOLUNTEER REGISTRATION HORIZONTAL CARD SECTION -->
        <section class="section" id="volunteer">
            <div class="section-container">
                <div class="volunteer-horizontal" data-aos="fade-up">
                    <div class="volunteer-image" style="background-image: url('https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600&h=400&fit=crop');"></div>
                    <div class="volunteer-content">
                        <h3>Become a Volunteer</h3>
                        <p>Join our passionate team of volunteers and make a real difference in communities around the world. Whether you have a few hours or a few weeks, your skills and time can change lives. Together, we can build a better future.</p>
                        <a href="{{ route('volunteer') }}" class="btn-volunteer">
                            <i class="fas fa-hands-helping"></i> Register as a Volunteer
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section class="section" id="projects">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Our Active Projects</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Join us in making a difference</p>
                <div class="projects-grid">
                    <div class="project-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="project-image" style="background-image: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=250&fit=crop')">
                            <span class="project-category">WASH Initiative</span>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">Clean Water Initiative</h3>
                            <p class="project-description">Providing access to clean and safe drinking water in rural communities.</p>
                            <div class="project-stats">
                                <span>$45,000 raised</span>
                                <span>Goal: $100,000</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                            <a href="#" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Donate Now</a>
                        </div>
                    </div>

                    <div class="project-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="project-image" style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=250&fit=crop')">
                            <span class="project-category">Education</span>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">School Building Project</h3>
                            <p class="project-description">Building schools and providing educational resources to underprivileged children.</p>
                            <div class="project-stats">
                                <span>$78,000 raised</span>
                                <span>Goal: $150,000</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 52%"></div>
                            </div>
                            <a href="#" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Donate Now</a>
                        </div>
                    </div>

                    <div class="project-card" data-aos="fade-up" data-aos-delay="250">
                        <div class="project-image" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=250&fit=crop')">
                            <span class="project-category">Healthcare</span>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">Medical Camps</h3>
                            <p class="project-description">Free healthcare camps providing essential medical services to remote areas.</p>
                            <div class="project-stats">
                                <span>$32,000 raised</span>
                                <span>Goal: $80,000</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 40%"></div>
                            </div>
                            <a href="#" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Donate Now</a>
                        </div>
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
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="150">
                        <a href="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&h=600&fit=crop" data-lightbox="gallery">
                            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=400&h=250&fit=crop" alt="Gallery Image 1">
                            <div class="gallery-overlay">
                                <p>Community outreach program</p>
                            </div>
                        </a>
                    </div>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                        <a href="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=800&h=600&fit=crop" data-lightbox="gallery">
                            <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=250&fit=crop" alt="Gallery Image 2">
                            <div class="gallery-overlay">
                                <p>Clean water project</p>
                            </div>
                        </a>
                    </div>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="250">
                        <a href="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&h=600&fit=crop" data-lightbox="gallery">
                            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=250&fit=crop" alt="Gallery Image 3">
                            <div class="gallery-overlay">
                                <p>Education program</p>
                            </div>
                        </a>
                    </div>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                        <a href="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&h=600&fit=crop" data-lightbox="gallery">
                            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=250&fit=crop" alt="Gallery Image 4">
                            <div class="gallery-overlay">
                                <p>Medical camp</p>
                            </div>
                        </a>
                    </div>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="350">
                        <a href="https://images.unsplash.com/photo-1559027615-82f7d295a4f6?w=800&h=600&fit=crop" data-lightbox="gallery">
                            <img src="https://images.unsplash.com/photo-1559027615-82f7d295a4f6?w=400&h=250&fit=crop" alt="Gallery Image 5">
                            <div class="gallery-overlay">
                                <p>Volunteer training</p>
                            </div>
                        </a>
                    </div>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                        <a href="https://images.unsplash.com/photo-1593113630400-ea4288922497?w=800&h=600&fit=crop" data-lightbox="gallery">
                            <img src="https://images.unsplash.com/photo-1593113630400-ea4288922497?w=400&h=250&fit=crop" alt="Gallery Image 6">
                            <div class="gallery-overlay">
                                <p>Community celebration</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact Stats Section -->
        <section class="impact-section section">
            <div class="section-container">
                <div class="impact-grid">
                    <div class="impact-item" data-aos="zoom-in">
                        <h2>50,000+</h2>
                        <p>Children Educated</p>
                    </div>
                    <div class="impact-item" data-aos="zoom-in" data-aos-delay="100">
                        <h2>$2.5M+</h2>
                        <p>Funds Raised</p>
                    </div>
                    <div class="impact-item" data-aos="zoom-in" data-aos-delay="200">
                        <h2>10,000+</h2>
                        <p>Volunteer Hours</p>
                    </div>
                    <div class="impact-item" data-aos="zoom-in" data-aos-delay="300">
                        <h2>150+</h2>
                        <p>Communities Served</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Blog/News Section -->
        <section class="section" id="blog">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Recent News & Stories</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Stay updated with our latest impact stories</p>
                <div class="blog-grid">
                    <div class="blog-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop')"></div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i> March 15, 2024</span>
                                <span><i class="far fa-user"></i> Admin</span>
                            </div>
                            <h3 class="blog-title">New Clean Water Well Completed in Rural Village</h3>
                            <p class="blog-excerpt">Thanks to your generous donations, we've successfully completed a new water well serving over 500 families...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="blog-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=200&fit=crop')"></div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i> March 10, 2024</span>
                                <span><i class="far fa-user"></i> Admin</span>
                            </div>
                            <h3 class="blog-title">Annual Charity Gala Raises Record Amount</h3>
                            <p class="blog-excerpt">Our annual fundraising event brought together supporters from around the world, raising over $500,000 for education programs...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="blog-card" data-aos="fade-up" data-aos-delay="250">
                        <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=200&fit=crop')"></div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i> March 5, 2024</span>
                                <span><i class="far fa-user"></i> Admin</span>
                            </div>
                            <h3 class="blog-title">New Partnership with Local Healthcare Providers</h3>
                            <p class="blog-excerpt">We're excited to announce a new partnership that will expand access to healthcare services in remote regions...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="section" id="team" style="background: #f9f9f9;">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Our Leadership Team</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Meet the people behind our mission</p>
                <div class="team-grid">
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
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section class="section" id="events">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">Upcoming Events</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Get involved and make a difference</p>
                <div class="events-grid">
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
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="section" style="background: #f9f9f9;">
            <div class="section-container">
                <h2 class="section-title" data-aos="fade-up">What People Say</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Stories of impact and transformation</p>
                <div class="testimonials-grid">
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
                </div>
            </div>
        </section>

        <!-- PARTNERS & SPONSORS SECTION - HORIZONTAL LOGO SHOWCASE -->
        <section class="partners-section" id="partners">
            <div class="partners-container">
                <h2 class="partners-title" data-aos="fade-up">Our Partners & Sponsors</h2>
                <p class="partners-subtitle" data-aos="fade-up" data-aos-delay="100">Together we create lasting impact</p>
                <div class="partners-logos" data-aos="fade-up" data-aos-delay="150">
                    <div class="partner-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/United_Nations_Logo.svg/1200px-United_Nations_Logo.svg.png" alt="United Nations">
                        <p>United Nations</p>
                    </div>
                    <div class="partner-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/World_Health_Organization_Logo.svg/1200px-World_Health_Organization_Logo.svg.png" alt="WHO">
                        <p>World Health Org</p>
                    </div>
                    <div class="partner-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/UNICEF_Logo.svg/1200px-UNICEF_Logo.svg.png" alt="UNICEF">
                        <p>UNICEF</p>
                    </div>
                    <div class="partner-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Red_Cross_logo.svg/1200px-Red_Cross_logo.svg.png" alt="Red Cross">
                        <p>Red Cross</p>
                    </div>
                    <div class="partner-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/Google_Chrome_icon.svg/1200px-Google_Chrome_icon.svg.png" alt="Google.org">
                        <p>Google.org</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section section" id="donate">
            <div class="section-container">
                <h2 data-aos="fade-up">Ready to Make a Difference?</h2>
                <p data-aos="fade-up" data-aos-delay="100">Your donation, no matter the size, can change lives</p>
                <a href="#" class="btn-primary" data-aos="zoom-in" style="background: white; color: var(--primary);">
                    <i class="fas fa-heart"></i> Donate Today
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