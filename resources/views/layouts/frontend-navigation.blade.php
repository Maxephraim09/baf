@once
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            --text-dark: #1B1B18;
        }

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
        }
    </style>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (!navbar) {
                return;
            }

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        function toggleMenu() {
            const navLinks = document.getElementById('navLinks');
            if (navLinks) {
                navLinks.classList.toggle('active');
            }
        }
    </script>
@endonce

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
            <a href="#blog">News</a>
            <a href="#team">Team</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="{{ route('donate') }}" class="donate-btn">Donate Now</a>
        </div>
    </div>
</nav>
