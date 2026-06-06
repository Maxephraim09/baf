@extends('layouts.app')

@section('title', 'Thank You for Your Donation')

@section('content')
<style>
    .thankyou-container {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--bg-light) 0%, #f0f0f0 100%);
        position: relative;
        overflow: hidden;
    }

    .thankyou-container:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 400px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }

    .thankyou-card {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 30px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: slideUp 0.6s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .thankyou-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
        }
        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
        }
    }

    .success-icon i {
        font-size: 3.5rem;
        color: var(--primary);
    }

    .thankyou-header h1 {
        color: white;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .thankyou-header p {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.125rem;
    }

    .thankyou-body {
        padding: 2.5rem;
    }

    .donation-summary {
        background: var(--gray-50);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--gray-700);
    }

    .summary-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: white;
        border-radius: 12px;
    }

    .summary-label {
        font-weight: 600;
        color: var(--gray-600);
    }

    .summary-value {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.125rem;
    }

    .impact-message {
        background: linear-gradient(135deg, rgba(245, 48, 3, 0.05), rgba(245, 48, 3, 0.02));
        border-left: 4px solid var(--primary);
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .impact-message p {
        color: var(--gray-700);
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .impact-message p:last-child {
        margin-bottom: 0;
    }

    .impact-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .impact-stat {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .impact-stat:hover {
        transform: translateY(-5px);
    }

    .impact-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .impact-label {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .btn-primary, .btn-secondary {
        padding: 0.875rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: var(--gradient);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 48, 3, 0.3);
    }

    .btn-secondary {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-secondary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .share-section {
        text-align: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .share-title {
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--gray-700);
    }

    .share-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .share-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .share-btn:hover {
        transform: translateY(-3px);
    }

    .share-facebook { background: #1877f2; color: white; }
    .share-twitter { background: #1da1f2; color: white; }
    .share-linkedin { background: #0077b5; color: white; }
    .share-whatsapp { background: #25d366; color: white; }
    .share-email { background: var(--gray-600); color: white; }

    .receipt-note {
        text-align: center;
        margin-top: 1.5rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: 12px;
    }

    .receipt-note p {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .receipt-note a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .thankyou-card {
            margin: 1rem;
        }

        .thankyou-header h1 {
            font-size: 1.75rem;
        }

        .thankyou-body {
            padding: 1.5rem;
        }

        .impact-stats {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons a {
            justify-content: center;
        }

        .summary-details {
            grid-template-columns: 1fr;
        }
    }
</style>

@include('layouts.frontend-navigation')

<div class="thankyou-container">
    <div class="flex items-center justify-center min-h-screen py-16 px-4">
        <div class="thankyou-card">
            <!-- Header -->
            <div class="thankyou-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Thank You for Your Generosity!</h1>
                <p>Your kindness is changing lives</p>
            </div>

            <!-- Body -->
            <div class="thankyou-body">
                <!-- Donation Summary -->
                <div class="donation-summary">
                    <div class="summary-title">Donation Summary</div>
                    <div class="summary-details">
                        <div class="summary-item">
                            <span class="summary-label">Amount Donated</span>
                            <span class="summary-value">${{ number_format(session('donation_amount', 100), 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Donation Type</span>
                            <span class="summary-value">{{ ucfirst(session('donation_frequency', 'one-time')) }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Transaction ID</span>
                            <span class="summary-value">#{{ session('transaction_id', 'AGT' . rand(100000, 999999)) }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date</span>
                            <span class="summary-value">{{ now()->format('F j, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Impact Message -->
                <div class="impact-message">
                    <p>
                        <i class="fas fa-heart" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        <strong>Your donation makes a difference!</strong>
                    </p>
                    <p>
                        Thanks to supporters like you, we can continue our mission of empowering 
                        communities through education, healthcare, and sustainable development.
                    </p>
                    <p style="margin-top: 1rem; font-size: 0.95rem;">
                        "Every act of kindness, no matter how small, creates ripples of hope that 
                        transform lives and communities." — Agontara Foundation
                    </p>
                </div>

                <!-- Impact Statistics -->
                <div class="impact-stats">
                    <div class="impact-stat">
                        <div class="impact-number" id="childrenHelped">25+</div>
                        <div class="impact-label">Children can be educated</div>
                    </div>
                    <div class="impact-stat">
                        <div class="impact-number" id="familiesHelped">10+</div>
                        <div class="impact-label">Families get clean water</div>
                    </div>
                    <div class="impact-stat">
                        <div class="impact-number" id="medicalVisits">50+</div>
                        <div class="impact-label">Medical visits funded</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('home') }}" class="btn-primary">
                        <i class="fas fa-home"></i> Return Home
                    </a>
                    <a href="{{ route('donations.create') }}" class="btn-secondary">
                        <i class="fas fa-heart"></i> Make Another Donation
                    </a>
                    <a href="#" class="btn-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Receipt
                    </a>
                </div>

                <!-- Share Section -->
                <div class="share-section">
                    <div class="share-title">Share Your Impact</div>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/')) }}" 
                           target="_blank" class="share-btn share-facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode('I just donated to Agontara Foundation! Join me in making a difference.') }}&url={{ urlencode(url('/')) }}" 
                           target="_blank" class="share-btn share-twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url('/')) }}" 
                           target="_blank" class="share-btn share-linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode('I just donated to Agontara Foundation! Join me in making a difference. ' . url('/')) }}" 
                           target="_blank" class="share-btn share-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject=I supported Agontara Foundation&body=I just made a donation to Agontara Foundation. Join me in making a difference! {{ url('/') }}" 
                           class="share-btn share-email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Receipt Note -->
                <div class="receipt-note">
                    <p>
                        <i class="fas fa-envelope"></i> A receipt has been sent to your email address.
                        <br>
                        Need help? <a href="{{ route('contact') }}">Contact our support team</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.frontend-footer')
<script>
    // Animate impact numbers on load
    document.addEventListener('DOMContentLoaded', function() {
        // Get donation amount from session or default
        const amount = {{ session('donation_amount', 100) }};
        
        // Calculate impact based on donation amount
        const childrenEducated = Math.floor(amount / 25);
        const familiesWithWater = Math.floor(amount / 50);
        const medicalVisits = Math.floor(amount / 10);
        
        // Animate numbers
        animateNumber('childrenHelped', 0, childrenEducated, 1000);
        animateNumber('familiesHelped', 0, familiesWithWater, 1000);
        animateNumber('medicalVisits', 0, medicalVisits, 1000);
        
        function animateNumber(elementId, start, end, duration) {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= end) {
                    element.textContent = Math.floor(end) + '+';
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + '+';
                }
            }, 16);
        }
    });
</script>
@endsection