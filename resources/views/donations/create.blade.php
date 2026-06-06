@extends('layouts.app')

@section('title', 'Donate - Support Our Mission')

@section('content')
<style>
    .donation-container {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--bg-light) 0%, #f9f9f9 100%);
    }

    .donation-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 4rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .donation-header:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1920&h=400&fit=crop') center/cover;
        opacity: 0.1;
        pointer-events: none;
    }

    .donation-header h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        position: relative;
    }

    .donation-header p {
        font-size: 1.125rem;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .donation-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: -3rem;
        position: relative;
        z-index: 2;
    }

    .donation-tabs {
        display: flex;
        border-bottom: 2px solid var(--gray-200);
        background: white;
    }

    .donation-tab {
        flex: 1;
        text-align: center;
        padding: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: var(--gray-600);
        border-bottom: 3px solid transparent;
    }

    .donation-tab.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .donation-tab:hover:not(.active) {
        color: var(--primary);
        background: rgba(245, 48, 3, 0.05);
    }

    .donation-form {
        padding: 2rem;
    }

    .amount-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .amount-option {
        padding: 1rem;
        text-align: center;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 700;
        font-size: 1.25rem;
        background: white;
    }

    .amount-option:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
    }

    .amount-option.selected {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .custom-amount {
        margin-top: 1rem;
        position: relative;
    }

    .custom-amount input {
        width: 100%;
        padding: 1rem 1rem 1rem 2.5rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .custom-amount input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.1);
    }

    .currency-symbol {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 700;
        color: var(--gray-500);
    }

    .frequency-options {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .frequency-option {
        flex: 1;
        padding: 0.75rem;
        text-align: center;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        font-weight: 500;
    }

    .frequency-option.selected {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
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

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
    }

    .checkbox-group input {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .payment-method {
        padding: 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: var(--primary);
    }

    .payment-method.selected {
        background: rgba(245, 48, 3, 0.1);
        border-color: var(--primary);
    }

    .payment-method img {
        height: 30px;
        margin-bottom: 0.5rem;
    }

    .donate-btn {
        width: 100%;
        background: var(--gradient);
        color: white;
        border: none;
        padding: 1.25rem;
        border-radius: 12px;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .donate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 48, 3, 0.3);
    }

    .donate-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .impact-summary {
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
    }

    .impact-summary h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .impact-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .impact-stat {
        text-align: center;
    }

    .impact-stat .number {
        font-size: 1.5rem;
        font-weight: 800;
    }

    .impact-stat .label {
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .testimonial-box {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
        color: var(--text-dark);
    }

    .secure-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: 12px;
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .donation-header h1 {
            font-size: 2rem;
        }

        .donation-card {
            margin-top: -2rem;
        }

        .amount-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .impact-stats {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
    }
</style>

<div class="donation-container">
    <!-- Header -->
    <div class="donation-header">
        <h1>Make a Difference Today</h1>
        <p>Your generous donation helps us transform lives and build sustainable communities around the world.</p>
    </div>

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pb-16">
        <div class="donation-card">
            <!-- Tabs -->
            <div class="donation-tabs">
                <div class="donation-tab active" data-tab="one-time">
                    <i class="fas fa-heart"></i> One-Time Donation
                </div>
                <div class="donation-tab" data-tab="monthly">
                    <i class="fas fa-calendar-alt"></i> Monthly Donation
                </div>
                <div class="donation-tab" data-tab="quarterly">
                    <i class="fas fa-chart-line"></i> Quarterly Donation
                </div>
                <div class="donation-tab" data-tab="yearly">
                    <i class="fas fa-star"></i> Yearly Donation
                </div>
            </div>

            <!-- Form -->
            <div class="donation-form">
                <form id="donationForm" action="{{ route('donations.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="frequency" id="frequency" value="one-time">
                    <input type="hidden" name="payment_method" id="paymentMethod" value="stripe">

                    <!-- Impact Summary -->
                    <div class="impact-summary">
                        <h3>Your Impact</h3>
                        <p>See how your donation creates change:</p>
                        <div class="impact-stats">
                            <div class="impact-stat">
                                <div class="number" id="impactChildren">0</div>
                                <div class="label">Children Educated</div>
                            </div>
                            <div class="impact-stat">
                                <div class="number" id="impactFamilies">0</div>
                                <div class="label">Families with Clean Water</div>
                            </div>
                            <div class="impact-stat">
                                <div class="number" id="impactMedical">0</div>
                                <div class="label">Medical Visits Funded</div>
                            </div>
                        </div>
                    </div>

                    <!-- Donation Amount -->
                    <div class="form-group">
                        <label>Select Donation Amount</label>
                        <div class="amount-grid">
                            <div class="amount-option" data-amount="25">$25</div>
                            <div class="amount-option" data-amount="50">$50</div>
                            <div class="amount-option" data-amount="100">$100</div>
                            <div class="amount-option" data-amount="250">$250</div>
                            <div class="amount-option" data-amount="500">$500</div>
                            <div class="amount-option" data-amount="1000">$1,000</div>
                        </div>
                        <div class="custom-amount">
                            <span class="currency-symbol">$</span>
                            <input type="number" name="custom_amount" id="customAmount" placeholder="Custom amount" step="1" min="1">
                        </div>
                    </div>

                    <!-- Donor Information -->
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" required placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" required placeholder="john@example.com">
                        </div>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="+1 234 567 890">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country">
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="CA">Canada</option>
                                <option value="AU">Australia</option>
                                <option value="IN">India</option>
                            </select>
                        </div>
                    </div>

                    <!-- Optional Message -->
                    <div class="form-group">
                        <label>Message (Optional)</label>
                        <textarea name="message" rows="3" placeholder="I want to support because..."></textarea>
                    </div>

                    <!-- Anonymous Donation -->
                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" name="anonymous" value="1">
                            <span>Make this donation anonymous</span>
                        </label>
                    </div>

                    <!-- Dedication -->
                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" id="dedicationCheckbox">
                            <span>Dedicate this donation in honor/memory of someone</span>
                        </label>
                        <div id="dedicationFields" style="display: none; margin-top: 1rem;">
                            <input type="text" name="dedication_name" placeholder="Name of person" class="form-control" style="margin-bottom: 0.5rem;">
                            <select name="dedication_type">
                                <option value="honor">In Honor Of</option>
                                <option value="memory">In Memory Of</option>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="form-group">
                        <label>Payment Method</label>
                        <div class="payment-methods">
                            <div class="payment-method selected" data-method="stripe">
                                <img src="https://stripe.com/img/about/logos/logos/black.png" alt="Stripe" style="height: 30px; margin: 0 auto;">
                                <div>Credit/Debit Card</div>
                            </div>
                            <div class="payment-method" data-method="paypal">
                                <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal">
                                <div>PayPal</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Card Element (shown when Stripe is selected) -->
                    <div id="stripeElement" class="form-group">
                        <label>Card Details</label>
                        <div id="card-element" style="border: 2px solid var(--gray-200); border-radius: 12px; padding: 0.875rem;"></div>
                        <div id="card-errors" role="alert" style="color: var(--danger); margin-top: 0.5rem; font-size: 0.875rem;"></div>
                    </div>

                    <!-- Secure Badge -->
                    <div class="secure-badge">
                        <i class="fas fa-lock"></i>
                        <span>Your donation is secure and encrypted</span>
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="donate-btn" id="donateButton">
                        <i class="fas fa-heart"></i>
                        <span id="donateButtonText">Donate $25</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-12 text-center">
            <h3 class="text-xl font-semibold mb-4">Frequently Asked Questions</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <i class="fas fa-receipt text-2xl" style="color: var(--primary);"></i>
                    <p class="font-semibold mt-2">Tax Deductible?</p>
                    <p class="text-sm text-gray-600">Yes, all donations are tax-deductible. You'll receive a receipt via email.</p>
                </div>
                <div>
                    <i class="fas fa-shield-alt text-2xl" style="color: var(--primary);"></i>
                    <p class="font-semibold mt-2">Secure Payment</p>
                    <p class="text-sm text-gray-600">We use SSL encryption and trusted payment processors.</p>
                </div>
                <div>
                    <i class="fas fa-chart-line text-2xl" style="color: var(--primary);"></i>
                    <p class="font-semibold mt-2">Where does my money go?</p>
                    <p class="text-sm text-gray-600">85% goes directly to programs, 15% to operations and fundraising.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    // Stripe initialization
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '"Instrument Sans", Helvetica, sans-serif',
                '::placeholder': { color: '#aab7c4' }
            }
        }
    });
    cardElement.mount('#card-element');

    // Handle card errors
    cardElement.addEventListener('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Form handling
    let selectedAmount = 25;
    let selectedFrequency = 'one-time';
    let selectedPaymentMethod = 'stripe';

    // Amount selection
    document.querySelectorAll('.amount-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.amount-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            selectedAmount = parseInt(this.dataset.amount);
            document.getElementById('customAmount').value = '';
            updateImpactStats(selectedAmount);
            updateButtonText();
        });
    });

    // Custom amount
    document.getElementById('customAmount').addEventListener('input', function() {
        document.querySelectorAll('.amount-option').forEach(opt => opt.classList.remove('selected'));
        selectedAmount = parseFloat(this.value) || 0;
        updateImpactStats(selectedAmount);
        updateButtonText();
    });

    // Frequency selection
    document.querySelectorAll('.donation-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.donation-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            selectedFrequency = this.dataset.tab;
            document.getElementById('frequency').value = selectedFrequency;
            updateButtonText();
        });
    });

    // Payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function() {
            document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
            this.classList.add('selected');
            selectedPaymentMethod = this.dataset.method;
            document.getElementById('paymentMethod').value = selectedPaymentMethod;
            
            // Show/hide Stripe element
            const stripeElement = document.getElementById('stripeElement');
            if (selectedPaymentMethod === 'stripe') {
                stripeElement.style.display = 'block';
            } else {
                stripeElement.style.display = 'none';
            }
        });
    });

    // Dedication toggle
    document.getElementById('dedicationCheckbox').addEventListener('change', function() {
        const dedicationFields = document.getElementById('dedicationFields');
        dedicationFields.style.display = this.checked ? 'block' : 'none';
    });

    // Update impact stats
    function updateImpactStats(amount) {
        if (!amount || amount <= 0) return;
        
        // Example calculations - adjust based on your actual costs
        const childrenEducated = Math.floor(amount / 25); // $25 per child
        const familiesWithWater = Math.floor(amount / 50); // $50 per family
        const medicalVisits = Math.floor(amount / 10); // $10 per medical visit
        
        document.getElementById('impactChildren').textContent = childrenEducated;
        document.getElementById('impactFamilies').textContent = familiesWithWater;
        document.getElementById('impactMedical').textContent = medicalVisits;
    }

    // Update button text
    function updateButtonText() {
        const amount = selectedAmount > 0 ? selectedAmount : 0;
        const frequencyText = {
            'one-time': 'Donate',
            'monthly': 'Donate Monthly',
            'quarterly': 'Donate Quarterly',
            'yearly': 'Donate Yearly'
        };
        const buttonText = `${frequencyText[selectedFrequency]} $${amount.toLocaleString()}`;
        document.getElementById('donateButtonText').textContent = buttonText;
    }

    // Form submission
    const form = document.getElementById('donationForm');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const amount = selectedAmount;
        if (!amount || amount <= 0) {
            alert('Please select or enter a donation amount');
            return;
        }
        
        const button = document.getElementById('donateButton');
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        
        if (selectedPaymentMethod === 'stripe') {
            // Create payment intent via AJAX
            try {
                const response = await fetch('{{ route("donations.create-payment-intent") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: amount,
                        frequency: selectedFrequency
                    })
                });
                
                const data = await response.json();
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Confirm card payment
                const result = await stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: document.querySelector('input[name="name"]').value,
                            email: document.querySelector('input[name="email"]').value
                        }
                    }
                });
                
                if (result.error) {
                    throw new Error(result.error.message);
                } else if (result.paymentIntent.status === 'succeeded') {
                    // Payment successful, submit form
                    const formData = new FormData(form);
                    formData.append('payment_intent_id', result.paymentIntent.id);
                    formData.append('amount', amount);
                    
                    const submitResponse = await fetch('{{ route("donations.store") }}', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const resultData = await submitResponse.json();
                    if (resultData.success) {
                        window.location.href = '{{ route("donations.thank-you") }}';
                    } else {
                        alert('Something went wrong. Please contact support.');
                    }
                }
            } catch (error) {
                alert(error.message);
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-heart"></i><span>Try Again</span>';
            }
        } else if (selectedPaymentMethod === 'paypal') {
            // Redirect to PayPal
            const formData = new FormData(form);
            formData.append('amount', amount);
            formData.append('frequency', selectedFrequency);
            
            const response = await fetch('{{ route("donations.paypal") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        }
    });
</script>
@endsection