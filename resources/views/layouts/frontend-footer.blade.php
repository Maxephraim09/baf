@php
    $general = $siteSettings['general'] ?? [];
    $orgName = $general['org_name'] ?? config('app.name', 'Agontara Foundation');
@endphp

@once
    <style>
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
            margin: 0;
            padding: 0;
        }

        .footer-col ul li {
            margin-bottom: 0.75rem;
            color: #a0a0a0;
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
            color: white;
            text-decoration: none;
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

        .footer-bottom a {
            color: white;
        }
    </style>
@endonce

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
        <p>&copy; 2024 Agontara Foundation. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a> | <a href="#">Cookie Policy</a></p>
    </div>
</footer>
