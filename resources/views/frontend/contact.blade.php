@extends('layouts.app')

@section('title', 'Contact Us - Get in Touch')
@section('hideDefaultNavigation', true)

@section('content')
<style>
    .contact-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 8rem 2rem 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .contact-header:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1920&h=400&fit=crop') center/cover;
        opacity: 0.1;
    }

    .contact-header h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        position: relative;
    }

    .contact-header p {
        font-size: 1.125rem;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        opacity: 0.95;
    }

    .contact-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: -3rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 2;
    }

    .info-card {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-10px);
    }

    .info-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .info-icon i {
        font-size: 2rem;
        color: white;
    }

    .info-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .info-card p {
        color: var(--gray-600);
        line-height: 1.6;
    }

    .contact-form-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.1);
    }

    .submit-btn {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 48, 3, 0.3);
    }

    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border: none;
    }

    .faq-section {
        background: var(--gray-50);
        border-radius: 20px;
        padding: 2rem;
    }

    .faq-item {
        background: white;
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .faq-question {
        padding: 1.25rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        color: var(--primary);
    }

    .faq-answer {
        padding: 0 1.25rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        color: var(--gray-600);
        line-height: 1.6;
    }

    .faq-item.active .faq-answer {
        padding: 0 1.25rem 1.25rem;
        max-height: 300px;
    }

    .social-links-section {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .social-link {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .social-link:hover {
        transform: translateY(-5px);
        background: var(--primary);
    }

    .social-link:hover i {
        color: white;
    }

    .social-link i {
        font-size: 1.5rem;
        color: var(--primary);
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .contact-header h1 {
            font-size: 2rem;
        }

        .contact-info-grid {
            grid-template-columns: 1fr;
            margin-top: -2rem;
        }

        .map-container iframe {
            height: 300px;
        }
    }
</style>

@include('layouts.frontend-navigation')
        
<div class="contact-header">
    <h1>Get in Touch</h1>
    <p>Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
</div>

<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pb-16">
    <!-- Contact Information Cards -->
    <div class="contact-info-grid">
        <div class="info-card" data-aos="fade-up">
            <div class="info-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3>Visit Us</h3>
            <p>123 Charity Street<br>City, Country 12345<br>United States</p>
        </div>

        <div class="info-card" data-aos="fade-up" data-aos-delay="100">
            <div class="info-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h3>Call Us</h3>
            <p>Main Office: +1 (234) 567-8900<br>Support: +1 (234) 567-8901<br>Mon-Fri, 9AM-6PM</p>
        </div>

        <div class="info-card" data-aos="fade-up" data-aos-delay="200">
            <div class="info-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h3>Email Us</h3>
            <p>General Inquiries: info@agontara.org<br>Support: support@agontara.org<br>Partnerships: partners@agontara.org</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="contact-form-container" data-aos="fade-right">
            <h2 class="text-2xl font-bold mb-6">Send Us a Message</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label>Subject *</label>
                        <select name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="donation" {{ old('subject') == 'donation' ? 'selected' : '' }}>Donation Question</option>
                            <option value="volunteer" {{ old('subject') == 'volunteer' ? 'selected' : '' }}>Volunteering</option>
                            <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership Opportunity</option>
                            <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                            <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Message *</label>
                    <textarea name="message" rows="5" required placeholder="Please provide details about your inquiry...">{{ old('message') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}>
                        <span>Subscribe to our newsletter for updates and impact stories</span>
                    </label>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

        <!-- Office Hours & Quick Contact -->
        <div data-aos="fade-left">
            <div class="contact-form-container">
                <h2 class="text-2xl font-bold mb-6">Office Hours</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="font-semibold">Monday - Friday</span>
                        <span class="text-gray-600">9:00 AM - 6:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="font-semibold">Saturday</span>
                        <span class="text-gray-600">10:00 AM - 4:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="font-semibold">Sunday</span>
                        <span class="text-gray-600">Closed</span>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold mb-3">Emergency Contact</h3>
                    <p class="text-gray-600">For urgent matters outside office hours:</p>
                    <p class="text-primary font-bold mt-2">+1 (234) 567-8999</p>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold mb-3">Follow Us</h3>
                    <div class="social-links-section">
                        <a href="#" class="social-link" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="map-container" data-aos="fade-up">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a316bb6db5b%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1699999999999!5m2!1sen!2sus" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-6 text-center">Frequently Asked Questions</h2>
        <div class="max-w-3xl mx-auto">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>How can I donate to Agontara Foundation?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    You can donate online through our secure donation page using credit/debit card or PayPal. You can also send a check to our office address or contact us for bank transfer details.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Is my donation tax-deductible?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Yes, Agontara Foundation is a registered 501(c)(3) non-profit organization. All donations are tax-deductible to the extent allowed by law. You will receive a receipt for your records.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>How can I volunteer with your organization?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    We welcome volunteers! Please fill out the contact form with "Volunteering" as the subject, and our volunteer coordinator will reach out with opportunities that match your skills and availability.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>How do I apply for a partnership or grant?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    We partner with organizations that share our mission. Please email partners@agontara.org with your proposal, or select "Partnership Opportunity" in the contact form above.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>How are my donations used?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    85% of donations go directly to our programs (education, healthcare, clean water, community development), while 15% supports operational costs and fundraising efforts.
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.frontend-footer')

<script>
    function toggleFAQ(element) {
        const faqItem = element.parentElement;
        faqItem.classList.toggle('active');
        
        // Close other FAQs
        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem && item.classList.contains('active')) {
                item.classList.remove('active');
            }
        });
    }
</script>
@endsection
