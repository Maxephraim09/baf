@extends('layouts.app')

@section('title', 'Donate - Support Our Mission')
@section('hideDefaultNavigation', true)

@section('content')
<style>
    .donation-page {
        background: linear-gradient(135deg, var(--bg-light) 0%, #f8fafc 100%);
        min-height: 100vh;
    }

    .donation-hero {
        background:
            linear-gradient(135deg, rgba(0, 0, 0, 0.62), rgba(0, 0, 0, 0.35)),
            url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1800&h=700&fit=crop') center/cover;
        color: white;
        padding: 8rem 1.5rem 7rem;
        text-align: center;
    }

    .donation-hero h1 {
        font-size: clamp(2.25rem, 6vw, 4rem);
        font-weight: 800;
        margin: 0 auto 1rem;
        max-width: 900px;
    }

    .donation-hero p {
        font-size: 1.125rem;
        line-height: 1.8;
        margin: 0 auto;
        max-width: 720px;
        opacity: 0.95;
    }

    .donation-wrap {
        margin: -4rem auto 0;
        max-width: 1180px;
        padding: 0 1rem 4rem;
    }

    .donation-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(300px, 0.8fr);
        gap: 1.5rem;
        align-items: start;
    }

    .donation-panel,
    .impact-panel {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
    }

    .donation-panel {
        padding: 2rem;
    }

    .impact-panel {
        padding: 1.5rem;
        position: sticky;
        top: 6rem;
    }

    .section-title {
        color: #111827;
        font-size: 1.35rem;
        font-weight: 800;
        margin: 0 0 1rem;
    }

    .amount-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .amount-option {
        background: #fff;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        color: #111827;
        cursor: pointer;
        font-size: 1.15rem;
        font-weight: 800;
        padding: 1rem;
        text-align: center;
        transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .amount-option.selected,
    .amount-option:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #374151;
        display: block;
        font-weight: 700;
        margin-bottom: 0.45rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font: inherit;
        padding: 0.85rem 1rem;
        width: 100%;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.12);
        outline: none;
    }

    .checkbox-line {
        align-items: center;
        display: flex;
        gap: 0.65rem;
        font-weight: 600;
    }

    .checkbox-line input {
        height: 18px;
        width: 18px;
    }

    .submit-donation {
        align-items: center;
        background: var(--primary);
        border: 0;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        display: inline-flex;
        font-size: 1rem;
        font-weight: 800;
        gap: 0.65rem;
        justify-content: center;
        margin-top: 0.5rem;
        padding: 1rem 1.5rem;
        width: 100%;
    }

    .submit-donation:hover {
        filter: brightness(0.95);
    }

    .notice {
        border-radius: 8px;
        margin-bottom: 1rem;
        padding: 1rem;
    }

    .notice.error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .impact-list {
        display: grid;
        gap: 1rem;
        margin: 1rem 0 1.5rem;
    }

    .impact-item {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1rem;
    }

    .impact-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .impact-item strong {
        color: var(--primary);
        display: block;
        font-size: 1.5rem;
    }

    .trust-note {
        background: #f9fafb;
        border-radius: 8px;
        color: #4b5563;
        line-height: 1.7;
        padding: 1rem;
    }

    @media (max-width: 900px) {
        .donation-grid,
        .form-grid {
            grid-template-columns: 1fr;
        }

        .impact-panel {
            position: static;
        }
    }

    @media (max-width: 560px) {
        .amount-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .donation-panel {
            padding: 1.25rem;
        }
    }
</style>

@include('layouts.frontend-navigation')

<div class="donation-page">
    <section class="donation-hero">
        <h1>Make a Difference Today</h1>
        <p>Your generous gift helps Agontara Foundation provide education, healthcare, clean water, and community support where it is needed most.</p>
    </section>

    <div class="donation-wrap">
        <div class="donation-grid">
            <div class="donation-panel">
                <h2 class="section-title">Donation Details</h2>

                @if(isset($errors) && $errors->any())
                    <div class="notice error">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('donations.store') }}" method="POST" id="publicDonationForm">
                    @csrf
                    <input type="hidden" name="amount" id="selectedAmount" value="{{ old('amount', 50) }}">
                    <input type="hidden" name="payment_method" value="manual">

                    <div class="form-group">
                        <label>Select Donation Amount *</label>
                        <div class="amount-grid">
                            @foreach([25, 50, 100, 250, 500, 1000] as $amount)
                                <button
                                    type="button"
                                    class="amount-option {{ (int) old('amount', 50) === $amount ? 'selected' : '' }}"
                                    data-amount="{{ $amount }}"
                                >
                                    ${{ number_format($amount) }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="customAmount">Custom Amount</label>
                            <input type="number" id="customAmount" min="1" step="1" placeholder="Enter amount">
                        </div>

                        <div class="form-group">
                            <label for="frequency">Donation Frequency *</label>
                            <select name="frequency" id="frequency" required>
                                <option value="one-time" @selected(old('frequency') === 'one-time')>One-time</option>
                                <option value="monthly" @selected(old('frequency') === 'monthly')>Monthly</option>
                                <option value="quarterly" @selected(old('frequency') === 'quarterly')>Quarterly</option>
                                <option value="yearly" @selected(old('frequency') === 'yearly')>Yearly</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="John Doe">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="john@example.com">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+1 234 567 890">
                        </div>

                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" name="country" id="country" value="{{ old('country') }}" placeholder="United States">
                        </div>

                        <div class="form-group full">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="4" placeholder="I want to support because...">{{ old('message') }}</textarea>
                        </div>

                        <div class="form-group full">
                            <label class="checkbox-line">
                                <input type="checkbox" name="anonymous" value="1" @checked(old('anonymous'))>
                                <span>Make this donation anonymous</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="dedication_name">Dedication Name</label>
                            <input type="text" name="dedication_name" id="dedication_name" value="{{ old('dedication_name') }}" placeholder="Optional">
                        </div>

                        <div class="form-group">
                            <label for="dedication_type">Dedication Type</label>
                            <select name="dedication_type" id="dedication_type">
                                <option value="">No dedication</option>
                                <option value="honor" @selected(old('dedication_type') === 'honor')>In Honor Of</option>
                                <option value="memory" @selected(old('dedication_type') === 'memory')>In Memory Of</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="submit-donation">
                        <i class="fas fa-heart"></i>
                        <span id="submitText">Donate ${{ number_format((float) old('amount', 50)) }}</span>
                    </button>
                </form>
            </div>

            <aside class="impact-panel">
                <h2 class="section-title">Your Impact</h2>
                <div class="impact-list">
                    <div class="impact-item">
                        <strong id="impactChildren">2</strong>
                        <span>children can receive learning supplies</span>
                    </div>
                    <div class="impact-item">
                        <strong id="impactMeals">10</strong>
                        <span>nutritious meals can be provided</span>
                    </div>
                    <div class="impact-item">
                        <strong id="impactCare">5</strong>
                        <span>basic healthcare visits can be supported</span>
                    </div>
                </div>

                <div class="trust-note">
                    <strong>Secure pledge record</strong><br>
                    This public form records your donation pledge and sends you to a thank-you page. Payment gateway integration can be added later when Stripe or PayPal credentials and packages are configured.
                </div>
            </aside>
        </div>
    </div>
</div>

@include('layouts.frontend-footer')

<script>
    const amountInput = document.getElementById('selectedAmount');
    const customAmount = document.getElementById('customAmount');
    const submitText = document.getElementById('submitText');
    const impactChildren = document.getElementById('impactChildren');
    const impactMeals = document.getElementById('impactMeals');
    const impactCare = document.getElementById('impactCare');

    function setAmount(amount) {
        const numericAmount = Number(amount) || 0;
        amountInput.value = numericAmount;
        submitText.textContent = `Donate $${numericAmount.toLocaleString()}`;
        impactChildren.textContent = Math.max(1, Math.floor(numericAmount / 25)).toLocaleString();
        impactMeals.textContent = Math.max(1, Math.floor(numericAmount / 5)).toLocaleString();
        impactCare.textContent = Math.max(1, Math.floor(numericAmount / 10)).toLocaleString();
    }

    document.querySelectorAll('.amount-option').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.amount-option').forEach((item) => item.classList.remove('selected'));
            button.classList.add('selected');
            customAmount.value = '';
            setAmount(button.dataset.amount);
        });
    });

    customAmount.addEventListener('input', () => {
        document.querySelectorAll('.amount-option').forEach((item) => item.classList.remove('selected'));
        setAmount(customAmount.value);
    });

    setAmount(amountInput.value);
</script>
@endsection
