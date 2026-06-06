# 🌟 Agontara Foundation - Modern NGO Website

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)

## 📖 Overview

Agontara Foundation is a comprehensive, feature-rich NGO management platform built with modern web technologies. It provides an all-in-one solution for donation management, volunteer coordination, campaign tracking, event management, and impact measurement.

### 🎯 Mission
Empowering non-profit organizations with cutting-edge technology to maximize their social impact through seamless donor engagement, efficient volunteer management, and transparent impact tracking.

### ✨ Key Features

| Category | Features |
|----------|----------|
| 💰 **Donations** | One-time & recurring, multiple gateways (Stripe/PayPal/Razorpay), tax receipts, anonymous giving |
| 🤝 **Volunteers** | Smart matching, hour tracking, certificates, automated scheduling |
| 📢 **Campaigns** | Real-time progress, milestone tracking, impact metrics, fundraising goals |
| 🎪 **Events** | Ticketing, QR check-in, virtual/hybrid support, calendar integration |
| 📊 **Analytics** | Real-time dashboard, geographic mapping, exportable reports |
| 📝 **Content** | Blog, success stories, news, SEO optimized, social sharing |
| 🌍 **Multi-language** | 5+ languages, RTL support, currency converter |
| 📱 **PWA** | Offline access, push notifications, app-like experience |
| 🔒 **Security** | GDPR compliant, 2FA, role-based access, audit logging |

## 🚀 Quick Start

### Prerequisites

```bash
# Required versions
PHP >= 8.1
Composer >= 2.0
Node.js >= 18.0
MySQL >= 8.0 / PostgreSQL >= 14
Redis >= 6.0 (for queue & cache)
```

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/agontara/ngo-website.git
cd ngo-website

# 2. Install PHP dependencies
composer install

# 3. Install NPM dependencies
npm install

# 4. Environment configuration
cp .env.example .env
php artisan key:generate

# 5. Configure database & services in .env
# Update DB_*, STRIPE_*, PAYPAL_*, etc.

# 6. Run migrations & seeders
php artisan migrate --seed

# 7. Create storage link
php artisan storage:link

# 8. Build assets
npm run build

# 9. Start queue worker (in separate terminal)
php artisan queue:work

# 10. Start development server
php artisan serve
```

### Docker Setup (Alternative)

```bash
# Build and run with Docker Compose
docker-compose up -d

# Run migrations
docker exec -it ngo-app php artisan migrate --seed

# Access the application at http://localhost:8000
```

## 📁 Project Structure

```
agontara-ngo/
├── app/
│   ├── Console/              # Custom commands
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # Custom middleware (GDPR, Language)
│   │   └── Livewire/         # Livewire components
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic (Payment, Matching)
│   ├── Jobs/                 # Queueable jobs
│   └── Mail/                 # Email classes
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Data seeders
│   └── factories/            # Model factories
├── resources/
│   ├── views/                # Blade templates
│   │   ├── livewire/         # Livewire views
│   │   ├── components/       # Reusable components
│   │   └── layouts/          # Layout templates
│   ├── css/                  # Stylesheets (Tailwind)
│   └── js/                   # JavaScript (Alpine.js)
├── routes/
│   ├── web.php               # Web routes
│   ├── api.php               # REST API routes
│   └── channels.php          # Broadcast channels
├── public/                   # Public assets
├── storage/                  # Generated files
├── tests/                    # Unit & Feature tests
├── config/                   # Configuration files
└── docker/                   # Docker configurations
```

## 💻 Technology Stack

### Backend
```json
{
  "framework": "Laravel 11.x",
  "language": "PHP 8.1+",
  "database": "MySQL 8.0 / PostgreSQL 14",
  "cache": "Redis 6.0+",
  "queue": "Redis / Beanstalkd",
  "search": "Elasticsearch 8.x"
}
```

### Frontend
```json
{
  "framework": "Livewire 3.x + Alpine.js 3.x",
  "styling": "TailwindCSS 3.x",
  "build_tool": "Vite 5.x",
  "charts": "Chart.js 4.x",
  "maps": "Leaflet / Google Maps"
}
```

### Third-Party Services
| Service | Purpose |
|---------|---------|
| Stripe/PayPal/Razorpay | Payment Processing |
| Mailgun/SendGrid | Email Delivery |
| Pusher | Real-time Events |
| AWS S3 | File Storage |
| Google Analytics | Tracking |
| Sentry | Error Tracking |

## 🔧 Configuration

### Environment Variables

```bash
# Application
APP_NAME="Agontara Foundation"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://agontara.org

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agontara_ngo
DB_USERNAME=root
DB_PASSWORD=secret

# Payment Gateways
STRIPE_KEY=pk_test_xxx
STRIPE_SECRET=sk_test_xxx
PAYPAL_CLIENT_ID=xxx
PAYPAL_SECRET=xxx
RAZORPAY_KEY=rzp_test_xxx
RAZORPAY_SECRET=xxx

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@mg.agontara.org
MAIL_PASSWORD=xxx

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# PWA
PWA_ENABLED=true
PWA_THEME_COLOR="#4F46E5"
```

## 🚢 Deployment

### Production Deployment Steps

```bash
# 1. Set correct permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data .

# 2. Install optimized dependencies
composer install --optimize-autoloader --no-dev

# 3. Build assets for production
npm run production

# 4. Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Run database migrations
php artisan migrate --force

# 6. Setup supervisor for queue
sudo cp deploy/supervisor/queue.conf /etc/supervisor/conf.d/
sudo supervisorctl reread
sudo supervisorctl update

# 7. Setup cron for scheduler
# Add to crontab: * * * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1

# 8. Configure web server (Nginx example)
sudo cp deploy/nginx/agontara.conf /etc/nginx/sites-available/
sudo ln -s /etc/nginx/sites-available/agontara.conf /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

### Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name agontara.org;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name agontara.org;
    
    ssl_certificate /etc/letsencrypt/live/agontara.org/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/agontara.org/privkey.pem;
    
    root /var/www/agontara/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }
    
    location ~ /\.ht {
        deny all;
    }
    
    # Static assets caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## 📊 API Documentation

### Authentication Endpoints

```http
POST   /api/auth/register     # User registration
POST   /api/auth/login        # User login
POST   /api/auth/logout       # User logout
POST   /api/auth/refresh      # Refresh token
GET    /api/auth/me           # Get user profile
```

### Donation Endpoints

```http
GET    /api/donations                # List donations (admin)
POST   /api/donations/process        # Process new donation
GET    /api/donations/{id}/receipt   # Download receipt
GET    /api/campaigns/{id}/progress  # Get campaign progress
POST   /api/donations/recurring/cancel # Cancel recurring donation
```

### Volunteer Endpoints

```http
GET    /api/volunteer/opportunities           # List opportunities
POST   /api/volunteer/apply                   # Submit application
GET    /api/volunteer/matches                 # Get matched opportunities
POST   /api/volunteer/hours/log               # Log volunteer hours
GET    /api/volunteer/certificate/{id}        # Download certificate
```

### Event Endpoints

```http
GET    /api/events                    # List upcoming events
POST   /api/events/{id}/register      # Register for event
GET    /api/events/{id}/ticket/{code} # Verify ticket
POST   /api/events/{id}/checkin       # QR code check-in
GET    /api/events/calendar.ics       # Download calendar
```

### Impact Analytics Endpoints

```http
GET    /api/impact/dashboard          # Real-time statistics
GET    /api/impact/geographic         # Geographic impact data
GET    /api/impact/report             # Generate impact report
GET    /api/impact/metrics            # Key performance metrics
```

### Example API Response

```json
{
    "success": true,
    "data": {
        "donation": {
            "id": "don_123456",
            "amount": 100.00,
            "currency": "USD",
            "status": "completed",
            "receipt_url": "https://agontara.org/receipts/don_123456.pdf",
            "created_at": "2024-01-15T10:30:00Z"
        }
    },
    "message": "Donation processed successfully"
}
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/DonationTest.php

# Pest testing (if using Pest)
./vendor/bin/pest
```

### Example Test

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Donation;

class DonationTest extends TestCase
{
    public function test_donation_processing()
    {
        $response = $this->postJson('/api/donations/process', [
            'donor_name' => 'John Doe',
            'donor_email' => 'john@example.com',
            'amount' => 100,
            'payment_method' => 'stripe',
            'payment_token' => 'pm_card_visa'
        ]);
        
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}
```

## 🔒 Security

### Features Implemented
- ✅ **GDPR Compliance** - Data export/deletion requests
- ✅ **Two-Factor Authentication** - Time-based OTP
- ✅ **Role-Based Access Control** - 4 role levels
- ✅ **CSRF Protection** - Token-based validation
- ✅ **XSS Prevention** - Output escaping & CSP headers
- ✅ **SQL Injection Protection** - Parameterized queries
- ✅ **Rate Limiting** - 100 requests per minute
- ✅ **Audit Logging** - All critical actions logged
- ✅ **File Upload Scanning** - Malware detection
- ✅ **HTTPS Enforcement** - Strict transport security

### Security Headers

```php
// App\Http\Middleware\SecurityHeaders.php
return [
    'X-Frame-Options' => 'DENY',
    'X-Content-Type-Options' => 'nosniff',
    'X-XSS-Protection' => '1; mode=block',
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
    'Content-Security-Policy' => "default-src 'self'",
    'Referrer-Policy' => 'strict-origin-when-cross-origin'
];
```

## 📈 Performance Optimization

### Caching Strategy
```php
// Cache frequently accessed data
Cache::remember('homepage_stats', 3600, fn() => [
    'total_donations' => Donation::sum('amount'),
    'active_volunteers' => Volunteer::count(),
    'beneficiaries' => Beneficiary::count()
]);

// Database indexing
Schema::table('donations', function($table) {
    $table->index(['status', 'created_at']);
    $table->index('donor_email');
});
```

### Performance Metrics
| Metric | Target | Current |
|--------|--------|---------|
| First Contentful Paint | < 1.5s | 0.9s |
| Time to Interactive | < 3.0s | 2.1s |
| API Response Time | < 200ms | 145ms |
| Database Query Time | < 50ms | 32ms |

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md).

```bash
# Development workflow
git checkout -b feature/amazing-feature
composer test
npm run lint
git commit -m 'Add amazing feature'
git push origin feature/amazing-feature
# Open Pull Request
```

### Code Standards
- PSR-12 for PHP
- ESLint for JavaScript
- Prettier for formatting
- PHPStan level 8 for static analysis

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Laravel Community** - For the amazing framework
- **TailwindCSS** - For the utility-first CSS
- **Livewire** - For dynamic UI components
- **Stripe/PayPal** - For payment processing
- **All Contributors** - Who help improve this platform

## 📞 Support

### Documentation
- [API Reference](https://docs.agontara.org/api)
- [User Guide](https://docs.agontara.org/guide)
- [Admin Manual](https://docs.agontara.org/admin)

### Contact
- **Email**: support@agontara.org
- **Twitter**: @AgontaraNGO
- **GitHub Issues**: [Create Issue](https://github.com/agontara/ngo-website/issues)

### Enterprise Support
For enterprise deployment, custom features, or priority support:
- **Email**: enterprise@agontara.org
- **SLA**: 24/7 support with 1-hour response time

---

## 🎯 Roadmap

### Version 2.0 (Q3 2024)
- [ ] AI-powered donation amount suggestions
- [ ] Blockchain-based donation tracking
- [ ] Advanced volunteer skill assessment
- [ ] Virtual reality event experiences
- [ ] WhatsApp bot integration

### Version 3.0 (Q1 2025)
- [ ] Decentralized autonomous organization (DAO) features
- [ ] Impact tokenization
- [ ] Cross-chain donation compatibility
- [ ] NFT-based recognition system

---

<div align="center">
  <strong>Made with ❤️ for a better world</strong>
  <br>
  <sub>© 2024 Agontara Foundation. All rights reserved.</sub>
</div>