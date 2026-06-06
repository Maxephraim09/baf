@extends('layouts.admin')

@section('content')
<div class="settings-wrapper">
    <div class="settings-container">
        <div class="settings-header">
            <h1><i class="fas fa-cog"></i> System Settings</h1>
            <p>Configure and manage your website settings</p>
        </div>

        @php
            $activeTab = session('active_tab', old('_active_tab', 'general'));
        @endphp

        <div class="settings-tabs-wrapper">
            <div class="settings-tabs">
                <button type="button" class="tab-btn {{ $activeTab === 'general' ? 'active' : '' }}" data-tab="general">
                    <i class="fas fa-globe"></i> General
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'branding' ? 'active' : '' }}" data-tab="branding">
                    <i class="fas fa-palette"></i> Branding
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'donation' ? 'active' : '' }}" data-tab="donation">
                    <i class="fas fa-hand-holding-heart"></i> Donation
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'payment' ? 'active' : '' }}" data-tab="payment">
                    <i class="fas fa-credit-card"></i> Payment
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'email' ? 'active' : '' }}" data-tab="email">
                    <i class="fas fa-envelope"></i> Email
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'social' ? 'active' : '' }}" data-tab="social">
                    <i class="fas fa-share-alt"></i> Social Media
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'seo' ? 'active' : '' }}" data-tab="seo">
                    <i class="fas fa-search"></i> SEO
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'security' ? 'active' : '' }}" data-tab="security">
                    <i class="fas fa-shield-alt"></i> Security
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'backup' ? 'active' : '' }}" data-tab="backup">
                    <i class="fas fa-database"></i> Backup
                </button>
                <button type="button" class="tab-btn {{ $activeTab === 'notifications' ? 'active' : '' }}" data-tab="notifications">
                    <i class="fas fa-bell"></i> Notifications
                </button>
            </div>
        </div>

        <div class="settings-content">
            @php
                $s = $settings ?? [];
                $general = $s['general'] ?? [];
                $branding = $s['branding'] ?? [];
                $logoLight = old('logo_light', $branding['logo_light'] ?? '');
                $logoDark = old('logo_dark', $branding['logo_dark'] ?? '');
                $favicon = old('favicon', $branding['favicon'] ?? '/favicon.ico');
                $donation = $s['donation'] ?? [];
                $payment = $s['payment'] ?? [];
                $email = $s['email'] ?? [];
                $social = $s['social'] ?? [];
                $seo = $s['seo'] ?? [];
                $security = $s['security'] ?? [];
                $notifications = $s['notifications'] ?? [];
                $backup = $s['backup'] ?? [];
            @endphp

            @if(session('success'))
                <div class="panel-card" style="margin-bottom:1rem; border-left:4px solid var(--success);">
                    <strong>Success:</strong> {{ session('success') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="panel-card" style="margin-bottom:1rem; border-left:4px solid var(--danger);">
                    <strong>Errors:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- General Settings -->
            <div class="tab-pane {{ $activeTab === 'general' ? 'active' : '' }}" id="general">
                <div class="settings-card">
                    <h3><i class="fas fa-info-circle"></i> General Information</h3>
                    <form id="generalSettingsForm" action="{{ route('admin.settings.update','general') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="general">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Organization Name</label>
                                <input type="text" name="org_name" value="{{ old('org_name', $general['org_name'] ?? 'Agontara Foundation') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Organization Tagline</label>
                                <input type="text" name="tagline" value="{{ old('tagline', $general['tagline'] ?? 'Empowering Communities, Transforming Lives') }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $general['phone'] ?? '+1 234 567 890') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $general['email'] ?? 'info@agontara.org') }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" rows="3" class="form-control">{{ old('address', $general['address'] ?? '123 Charity Street, City, Country, ZIP Code') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Working Hours</label>
                            <input type="text" name="working_hours" value="{{ old('working_hours', $general['working_hours'] ?? 'Monday - Friday: 9:00 AM - 6:00 PM') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>About Us (Short Description)</label>
                            <textarea name="about_short" rows="3" class="form-control">{{ old('about_short', $general['about_short'] ?? 'Agontara Foundation is a non-profit organization committed to empowering underserved communities through sustainable development initiatives.') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>About Us (Full Description)</label>
                            <textarea name="about_full" rows="5" class="form-control">{{ old('about_full', $general['about_full'] ?? 'Agontara Foundation is a non-profit organization committed to empowering underserved communities through sustainable development initiatives. We believe in creating lasting change by addressing root causes of poverty, inequality, and lack of access to essential services.') }}</textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Branding Settings -->
            <div class="tab-pane {{ $activeTab === 'branding' ? 'active' : '' }}" id="branding">
                <div class="settings-card">
                    <h3><i class="fas fa-palette"></i> Branding & Appearance</h3>
                    <form id="brandingSettingsForm" action="{{ route('admin.settings.update','branding') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_active_tab" value="branding">
                        <div class="form-group">
                            <label>Primary Color</label>
                            <div class="color-picker">
                                <input type="color" name="primary_color" value="{{ old('primary_color', $branding['primary_color'] ?? '#F53003') }}" class="color-input">
                                <input type="text" name="primary_color_hex" value="{{ old('primary_color_hex', $branding['primary_color_hex'] ?? ($branding['primary_color'] ?? '#F53003')) }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Secondary Color</label>
                            <div class="color-picker">
                                <input type="color" name="secondary_color" value="{{ old('secondary_color', $branding['secondary_color'] ?? '#1B1B18') }}" class="color-input">
                                <input type="text" name="secondary_color_hex" value="{{ old('secondary_color_hex', $branding['secondary_color_hex'] ?? ($branding['secondary_color'] ?? '#1B1B18')) }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Accent Color</label>
                            <div class="color-picker">
                                <input type="color" name="accent_color" value="{{ old('accent_color', $branding['accent_color'] ?? '#F8B803') }}" class="color-input">
                                <input type="text" name="accent_color_hex" value="{{ old('accent_color_hex', $branding['accent_color_hex'] ?? ($branding['accent_color'] ?? '#F8B803')) }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Logo (Light Mode)</label>
                            <div class="file-upload" data-upload="logo_light">
                                <input type="file" name="logo_light" accept="image/png,image/jpeg,image/webp,image/gif">
                                <div class="preview {{ $logoLight ? '' : 'is-empty' }}">
                                    <img src="{{ $logoLight }}" alt="Logo Light" @if(! $logoLight) hidden @endif>
                                    <span @if($logoLight) hidden @endif>No light logo uploaded</span>
                                </div>
                                <small class="file-name">PNG, JPG, GIF, or WebP up to 2 MB.</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Logo (Dark Mode)</label>
                            <div class="file-upload" data-upload="logo_dark">
                                <input type="file" name="logo_dark" accept="image/png,image/jpeg,image/webp,image/gif">
                                <div class="preview {{ $logoDark ? '' : 'is-empty' }}">
                                    <img src="{{ $logoDark }}" alt="Logo Dark" @if(! $logoDark) hidden @endif>
                                    <span @if($logoDark) hidden @endif>No dark logo uploaded</span>
                                </div>
                                <small class="file-name">PNG, JPG, GIF, or WebP up to 2 MB.</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Favicon</label>
                            <div class="file-upload" data-upload="favicon">
                                <input type="file" name="favicon" accept="image/png,image/jpeg,image/webp,image/gif,image/x-icon,image/vnd.microsoft.icon,.ico">
                                <div class="preview favicon-preview {{ $favicon ? '' : 'is-empty' }}">
                                    <img src="{{ $favicon }}" alt="Favicon" @if(! $favicon) hidden @endif>
                                    <span @if($favicon) hidden @endif>No favicon uploaded</span>
                                </div>
                                <small class="file-name">ICO, PNG, JPG, GIF, or WebP up to 1 MB.</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Default Language</label>
                            <select name="default_language" class="form-control">
                                <option value="en" {{ old('default_language', $branding['default_language'] ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ old('default_language', $branding['default_language'] ?? '') === 'es' ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ old('default_language', $branding['default_language'] ?? '') === 'fr' ? 'selected' : '' }}>French</option>
                                <option value="ar" {{ old('default_language', $branding['default_language'] ?? '') === 'ar' ? 'selected' : '' }}>Arabic</option>
                                <option value="hi" {{ old('default_language', $branding['default_language'] ?? '') === 'hi' ? 'selected' : '' }}>Hindi</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Date Format</label>
                            <select name="date_format" class="form-control">
                                <option value="Y-m-d" {{ old('date_format', $branding['date_format'] ?? 'Y-m-d') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="m/d/Y" {{ old('date_format', $branding['date_format'] ?? '') === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="d/m/Y" {{ old('date_format', $branding['date_format'] ?? '') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="F j, Y" {{ old('date_format', $branding['date_format'] ?? '') === 'F j, Y' ? 'selected' : '' }}>Month DD, YYYY</option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Donation Settings -->
            <div class="tab-pane {{ $activeTab === 'donation' ? 'active' : '' }}" id="donation">
                <div class="settings-card">
                    <h3><i class="fas fa-hand-holding-heart"></i> Donation Settings</h3>
                    <form id="donationSettingsForm" action="{{ route('admin.settings.update','donation') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="donation">
                        <div class="form-group">
                            <label>Minimum Donation Amount ($)</label>
                            <input type="number" name="min_donation" value="{{ old('min_donation', $donation['min_donation'] ?? 5) }}" class="form-control" step="1">
                        </div>
                        
                        <div class="form-group">
                            <label>Maximum Donation Amount ($)</label>
                            <input type="number" name="max_donation" value="{{ old('max_donation', $donation['max_donation'] ?? 10000) }}" class="form-control" step="100">
                        </div>
                        
                        <div class="form-group">
                            <label>Suggested Donation Amounts ($)</label>
                            <div class="suggested-amounts">
                                <input type="number" name="suggested_1" value="{{ old('suggested_1', $donation['suggested_1'] ?? 25) }}" class="form-control" placeholder="$25">
                                <input type="number" name="suggested_2" value="{{ old('suggested_2', $donation['suggested_2'] ?? 50) }}" class="form-control" placeholder="$50">
                                <input type="number" name="suggested_3" value="{{ old('suggested_3', $donation['suggested_3'] ?? 100) }}" class="form-control" placeholder="$100">
                                <input type="number" name="suggested_4" value="{{ old('suggested_4', $donation['suggested_4'] ?? 250) }}" class="form-control" placeholder="$250">
                                <input type="number" name="suggested_5" value="{{ old('suggested_5', $donation['suggested_5'] ?? 500) }}" class="form-control" placeholder="$500">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="recurring_donations" id="recurring" {{ old('recurring_donations', ($donation['recurring_donations'] ?? false)) ? 'checked' : '' }}>
                                <label for="recurring">Enable Recurring Donations</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Recurring Frequencies</label>
                            <div class="checkbox-group">
                                <label><input type="checkbox" name="frequency_weekly" checked> Weekly</label>
                                <label><input type="checkbox" name="frequency_monthly" checked> Monthly</label>
                                <label><input type="checkbox" name="frequency_quarterly" checked> Quarterly</label>
                                <label><input type="checkbox" name="frequency_yearly" checked> Yearly</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="anonymous_donations" id="anonymous" checked>
                                <label for="anonymous">Enable Anonymous Donations</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Annual Campaign Goal ($)</label>
                            <input type="number" name="campaign_goal" value="500000" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Campaign End Date</label>
                            <input type="date" name="campaign_end_date" value="2024-12-31" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Donation Thank You Message</label>
                            <textarea name="thankyou_message" rows="4" class="form-control">Thank you for your generous donation! Your support helps us make a difference in communities around the world.</textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Settings -->
            <div class="tab-pane {{ $activeTab === 'payment' ? 'active' : '' }}" id="payment">
                <div class="settings-card">
                    <h3><i class="fas fa-credit-card"></i> Payment Gateway Settings</h3>
                    <form id="paymentSettingsForm" action="{{ route('admin.settings.update','payment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="payment">
                        <div class="payment-gateways">
                            <div class="gateway-card">
                                <div class="gateway-header">
                                    <img src="https://stripe.com/img/about/logos/logos/black.png" alt="Stripe" style="height: 30px;">
                                    <div class="toggle-switch">
                                        <input type="checkbox" name="stripe_enabled" id="stripe" {{ old('stripe_enabled', ($payment['stripe_enabled'] ?? false)) ? 'checked' : '' }}>
                                        <label for="stripe">Enable Stripe</label>
                                    </div>
                                </div>
                                <div class="gateway-settings">
                                    <div class="form-group">
                                        <label>Publishable Key</label>
                                        <input type="text" name="stripe_key" class="form-control" value="{{ old('stripe_key', $payment['stripe_key'] ?? 'pk_test_xxxxxxxxxxxx') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Secret Key</label>
                                        <input type="password" name="stripe_secret" class="form-control" value="{{ old('stripe_secret', $payment['stripe_secret'] ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Webhook Secret</label>
                                        <input type="password" name="stripe_webhook" class="form-control" value="{{ old('stripe_webhook', $payment['stripe_webhook'] ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="gateway-card">
                                <div class="gateway-header">
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal" style="height: 30px;">
                                    <div class="toggle-switch">
                                        <input type="checkbox" name="paypal_enabled" id="paypal" {{ old('paypal_enabled', ($payment['paypal_enabled'] ?? false)) ? 'checked' : '' }}>
                                        <label for="paypal">Enable PayPal</label>
                                    </div>
                                </div>
                                <div class="gateway-settings">
                                    <div class="form-group">
                                        <label>Client ID</label>
                                        <input type="text" name="paypal_client_id" class="form-control" value="{{ old('paypal_client_id', $payment['paypal_client_id'] ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Client Secret</label>
                                        <input type="password" name="paypal_secret" class="form-control" value="{{ old('paypal_secret', $payment['paypal_secret'] ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Mode</label>
                                        <select name="paypal_mode" class="form-control">
                                            <option value="sandbox" {{ old('paypal_mode', ($payment['paypal_mode'] ?? 'live')) === 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                                            <option value="live" {{ old('paypal_mode', ($payment['paypal_mode'] ?? 'live')) === 'live' ? 'selected' : '' }}>Live</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="gateway-card">
                                <div class="gateway-header">
                                    <div class="gateway-brand paystack-brand">Paystack</div>
                                    <div class="toggle-switch">
                                        <input type="checkbox" name="paystack_enabled" id="paystack" {{ old('paystack_enabled', ($payment['paystack_enabled'] ?? false)) ? 'checked' : '' }}>
                                        <label for="paystack">Enable Paystack</label>
                                    </div>
                                </div>
                                <div class="gateway-settings">
                                    <div class="form-group">
                                        <label>Public Key</label>
                                        <input type="text" name="paystack_public_key" class="form-control" value="{{ old('paystack_public_key', $payment['paystack_public_key'] ?? '') }}" placeholder="pk_test_xxxxxxxxxxxx">
                                    </div>
                                    <div class="form-group">
                                        <label>Secret Key</label>
                                        <input type="password" name="paystack_secret_key" class="form-control" value="{{ old('paystack_secret_key', $payment['paystack_secret_key'] ?? '') }}" placeholder="sk_test_xxxxxxxxxxxx">
                                    </div>
                                    <div class="form-group">
                                        <label>Callback URL</label>
                                        <input type="url" name="paystack_callback_url" class="form-control" value="{{ old('paystack_callback_url', $payment['paystack_callback_url'] ?? route('donations.thank-you')) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Webhook URL</label>
                                        <input type="url" name="paystack_webhook_url" class="form-control" value="{{ old('paystack_webhook_url', $payment['paystack_webhook_url'] ?? url('/webhooks/paystack')) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Mode</label>
                                        <select name="paystack_mode" class="form-control">
                                            <option value="test" {{ old('paystack_mode', ($payment['paystack_mode'] ?? 'test')) === 'test' ? 'selected' : '' }}>Test</option>
                                            <option value="live" {{ old('paystack_mode', ($payment['paystack_mode'] ?? 'test')) === 'live' ? 'selected' : '' }}>Live</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Default Currency</label>
                            <select name="currency" class="form-control">
                                @php $cur = old('currency', $payment['currency'] ?? 'USD'); @endphp
                                <option value="USD" {{ $cur==='USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ $cur==='EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ $cur==='GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="CAD" {{ $cur==='CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                <option value="AUD" {{ $cur==='AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                <option value="INR" {{ $cur==='INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                                <option value="NGN" {{ $cur==='NGN' ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="tab-pane {{ $activeTab === 'email' ? 'active' : '' }}" id="email">
                <div class="settings-card">
                    <h3><i class="fas fa-envelope"></i> Email Configuration</h3>
                    <form id="emailSettingsForm" action="{{ route('admin.settings.update','email') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="email">
                        @php $email_old = old(); $emailCfg = $email; @endphp
                        <div class="form-group">
                            <label>Mail Driver</label>
                            @php $drv = old('mail_driver', $emailCfg['mail_driver'] ?? 'smtp'); @endphp
                            <select name="mail_driver" class="form-control">
                                <option value="smtp" {{ $drv==='smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ $drv==='sendmail' ? 'selected' : '' }}>Sendmail</option>
                                <option value="mailgun" {{ $drv==='mailgun' ? 'selected' : '' }}>Mailgun</option>
                                <option value="ses" {{ $drv==='ses' ? 'selected' : '' }}>Amazon SES</option>
                                <option value="postmark" {{ $drv==='postmark' ? 'selected' : '' }}>Postmark</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>SMTP Host</label>
                            <input type="text" name="smtp_host" value="{{ old('smtp_host', $emailCfg['smtp_host'] ?? 'smtp.gmail.com') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>SMTP Port</label>
                            <input type="text" name="smtp_port" value="{{ old('smtp_port', $emailCfg['smtp_port'] ?? '587') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>SMTP Username</label>
                            <input type="text" name="smtp_username" value="{{ old('smtp_username', $emailCfg['smtp_username'] ?? 'noreply@agontara.org') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>SMTP Password</label>
                            <input type="password" name="smtp_password" value="{{ old('smtp_password', $emailCfg['smtp_password'] ?? '') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Encryption</label>
                            @php $enc = old('encryption', $emailCfg['encryption'] ?? 'tls'); @endphp
                            <select name="encryption" class="form-control">
                                <option value="tls" {{ $enc==='tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ $enc==='ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>From Name</label>
                            <input type="text" name="from_name" value="{{ old('from_name', $emailCfg['from_name'] ?? 'Agontara Foundation') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>From Email</label>
                            <input type="email" name="from_email" value="{{ old('from_email', $emailCfg['from_email'] ?? 'info@agontara.org') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Send Test Email</label>
                            <div class="test-email">
                                <input type="email" placeholder="Enter email to test" class="form-control">
                                <button type="button" class="btn-secondary" onclick="sendTestEmail()">Send Test</button>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Social Media Settings -->
            <div class="tab-pane {{ $activeTab === 'social' ? 'active' : '' }}" id="social">
                <div class="settings-card">
                    <h3><i class="fas fa-share-alt"></i> Social Media Links</h3>
                    <form id="socialSettingsForm" action="{{ route('admin.settings.update','social') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_active_tab" value="social">
                        <div class="form-group">
                            <label><i class="fab fa-facebook-f"></i> Facebook</label>
                            <input type="url" name="facebook" value="{{ old('facebook', $social['facebook'] ?? 'https://facebook.com/agontara') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fab fa-twitter"></i> Twitter</label>
                            <input type="url" name="twitter" value="{{ old('twitter', $social['twitter'] ?? 'https://twitter.com/agontara') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fab fa-instagram"></i> Instagram</label>
                            <input type="url" name="instagram" value="{{ old('instagram', $social['instagram'] ?? 'https://instagram.com/agontara') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fab fa-linkedin-in"></i> LinkedIn</label>
                            <input type="url" name="linkedin" value="{{ old('linkedin', $social['linkedin'] ?? 'https://linkedin.com/company/agontara') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fab fa-youtube"></i> YouTube</label>
                            <input type="url" name="youtube" value="{{ old('youtube', $social['youtube'] ?? 'https://youtube.com/agontara') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Social Share Image</label>
                            <div class="file-upload">
                                <input type="file" name="social_share_image" accept="image/*">
                                <div class="preview">
                                    <img src="{{ old('social_share_image', $social['social_share_image'] ?? '/images/social-share.png') }}" alt="Social Share">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane {{ $activeTab === 'seo' ? 'active' : '' }}" id="seo">
                <div class="settings-card">
                    <h3><i class="fas fa-search"></i> SEO & Analytics</h3>
                    <form id="seoSettingsForm" action="{{ route('admin.settings.update','seo') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="seo">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $seo['meta_title'] ?? 'Agontara Foundation - Empowering Communities, Transforming Lives') }}" class="form-control">
                            <small>Recommended length: 50-60 characters</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $seo['meta_description'] ?? 'Agontara Foundation is a non-profit organization dedicated to empowering communities through education, healthcare, and sustainable development programs worldwide.') }}</textarea>
                            <small>Recommended length: 150-160 characters</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $seo['meta_keywords'] ?? 'NGO, charity, donation, community development, education, healthcare, sustainable development') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Google Analytics Tracking ID</label>
                            <input type="text" name="ga_tracking_id" value="{{ old('ga_tracking_id', $seo['ga_tracking_id'] ?? 'UA-XXXXXXXXX-X') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Google Tag Manager ID</label>
                            <input type="text" name="gtm_id" value="{{ old('gtm_id', $seo['gtm_id'] ?? 'GTM-XXXXXXX') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Facebook Pixel ID</label>
                            <input type="text" name="fb_pixel_id" value="{{ old('fb_pixel_id', $seo['fb_pixel_id'] ?? '') }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="enable_sitemap" id="sitemap" {{ old('enable_sitemap', ($seo['enable_sitemap'] ?? true)) ? 'checked' : '' }}>
                                <label for="sitemap">Auto-generate XML sitemap</label>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="tab-pane {{ $activeTab === 'security' ? 'active' : '' }}" id="security">
                <div class="settings-card">
                    <h3><i class="fas fa-shield-alt"></i> Security Settings</h3>
                    <form id="securitySettingsForm" action="{{ route('admin.settings.update','security') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="security">
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="twofa_enabled" id="2fa" {{ old('twofa_enabled', ($security['twofa_enabled'] ?? true)) ? 'checked' : '' }}>
                                <label for="2fa">Enable Two-Factor Authentication</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Session Timeout (minutes)</label>
                            <input type="number" name="session_timeout" value="{{ old('session_timeout', $security['session_timeout'] ?? 30) }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Maximum Login Attempts</label>
                            <input type="number" name="max_login_attempts" value="{{ old('max_login_attempts', $security['max_login_attempts'] ?? 5) }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Password Expiry (days)</label>
                            <input type="number" name="password_expiry" value="{{ old('password_expiry', $security['password_expiry'] ?? 90) }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Allowed IP Addresses (Whitelist)</label>
                            <textarea name="allowed_ips" rows="3" class="form-control" placeholder="One IP per line">{{ old('allowed_ips', $security['allowed_ips'] ?? '') }}</textarea>
                            <small>Leave empty to allow all IPs</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="maintenance_mode" id="maintenance" {{ old('maintenance_mode', ($security['maintenance_mode'] ?? false)) ? 'checked' : '' }}>
                                <label for="maintenance">Enable Maintenance Mode</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Maintenance Message</label>
                            <textarea name="maintenance_message" rows="3" class="form-control">{{ old('maintenance_message', $security['maintenance_message'] ?? "We're currently updating our website. Please check back soon!") }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="backup_encryption" id="backup_encrypt" {{ old('backup_encryption', ($security['backup_encryption'] ?? true)) ? 'checked' : '' }}>
                                <label for="backup_encrypt">Encrypt database backups</label>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Backup Settings -->
            <div class="tab-pane {{ $activeTab === 'backup' ? 'active' : '' }}" id="backup">
                <div class="settings-card">
                    <h3><i class="fas fa-database"></i> Backup & Restore</h3>
                    
                    <div class="backup-options">
                        <div class="backup-option">
                            <h4>Manual Backup</h4>
                            <p>Create a manual backup of your database and files</p>
                            <button class="btn-primary" onclick="createBackup()">
                                <i class="fas fa-database"></i> Create Backup Now
                            </button>
                        </div>
                        
                        <div class="backup-option">
                            <h4>Automatic Backup Schedule</h4>
                            @php $bks = old('backup_schedule', $backup['backup_schedule'] ?? 'weekly'); @endphp
                            <select name="backup_schedule" class="form-control">
                                <option value="daily" {{ $bks==='daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $bks==='weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $bks==='monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="disabled" {{ $bks==='disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="backup-list">
                        <h4>Available Backups</h4>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="backupList">
                                <tr>
                                    <td>backup_2024_03_15.sql</td>
                                    <td>45.2 MB</td>
                                    <td>2024-03-15 10:30 AM</td>
                                    <td>
                                        <button class="btn-icon btn-edit" onclick="downloadBackup()">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" onclick="deleteBackup()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn-icon btn-primary" onclick="restoreBackup()">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="import-export">
                        <h4>Import/Export Data</h4>
                        <div class="form-group">
                            <label>Export Data</label>
                            <div class="export-options">
                                <button type="button" class="btn-secondary" onclick="exportData('donations')">Export Donations</button>
                                <button type="button" class="btn-secondary" onclick="exportData('projects')">Export Projects</button>
                                <button type="button" class="btn-secondary" onclick="exportData('users')">Export Users</button>
                                <button type="button" class="btn-secondary" onclick="exportData('all')">Export All</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Import Data</label>
                            <form action="{{ route('admin.settings.update','backup') }}" method="POST" enctype="multipart/form-data" class="import-group">
                                @csrf
                                <input type="file" name="import_file" accept=".csv,.json,.sql" class="form-control">
                                <button type="submit" class="btn-primary">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings -->
            <div class="tab-pane {{ $activeTab === 'notifications' ? 'active' : '' }}" id="notifications">
                <div class="settings-card">
                    <h3><i class="fas fa-bell"></i> Notification Settings</h3>
                    <form id="notificationSettingsForm" action="{{ route('admin.settings.update','notifications') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_active_tab" value="notifications">
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="notify_donation" id="donation_notify" {{ old('notify_donation', ($notifications['notify_donation'] ?? true)) ? 'checked' : '' }}>
                                <label for="donation_notify">New Donation Alert</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="notify_volunteer" id="volunteer_notify" {{ old('notify_volunteer', ($notifications['notify_volunteer'] ?? true)) ? 'checked' : '' }}>
                                <label for="volunteer_notify">New Volunteer Registration</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="notify_event" id="event_notify" {{ old('notify_event', ($notifications['notify_event'] ?? true)) ? 'checked' : '' }}>
                                <label for="event_notify">New Event Registration</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="weekly_report" id="weekly_report" {{ old('weekly_report', ($notifications['weekly_report'] ?? true)) ? 'checked' : '' }}>
                                <label for="weekly_report">Weekly Reports</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="toggle-switch">
                                <input type="checkbox" name="monthly_report" id="monthly_report" {{ old('monthly_report', ($notifications['monthly_report'] ?? true)) ? 'checked' : '' }}>
                                <label for="monthly_report">Monthly Reports</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Admin Email Addresses</label>
                            <textarea name="admin_emails" rows="3" class="form-control" placeholder="admin1@example.com&#10;admin2@example.com">{{ old('admin_emails', $notifications['admin_emails'] ?? 'admin@agontara.org') }}</textarea>
                            <small>One email per line</small>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .settings-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
    }
    
    .settings-container {
        width: 100%;
    }
    
    .settings-header {
        margin-bottom: 2rem;
        padding: 0 0.5rem;
    }
    
    .settings-header h1 {
        font-size: 1.875rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }
    
    body.dark-mode .settings-header h1 {
        color: white;
    }
    
    .settings-header p {
        color: var(--text-light);
    }
    
    .settings-tabs-wrapper {
        background: white;
        border-radius: 12px;
        margin-bottom: 2rem;
        padding: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    body.dark-mode .settings-tabs-wrapper {
        background: var(--gray-800);
    }
    
    .settings-tabs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .tab-btn {
        padding: 0.75rem 1.25rem;
        background: transparent;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: var(--text-dark);
        white-space: nowrap;
    }
    
    body.dark-mode .tab-btn {
        color: var(--gray-300);
    }
    
    .tab-btn:hover {
        background: var(--gray-100);
    }
    
    body.dark-mode .tab-btn:hover {
        background: var(--gray-700);
    }
    
    .tab-btn.active {
        background: var(--primary);
        color: white;
    }
    
    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .settings-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    }
    
    body.dark-mode .settings-card {
        background: var(--gray-800);
    }
    
    .settings-card h3 {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
        color: var(--text-dark);
    }
    
    body.dark-mode .settings-card h3 {
        border-color: var(--gray-700);
        color: white;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    body.dark-mode .form-group label {
        color: var(--gray-300);
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: white;
        color: var(--text-dark);
    }
    
    body.dark-mode .form-control {
        background: var(--gray-700);
        border-color: var(--gray-600);
        color: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.1);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .color-picker {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .color-input {
        width: 60px;
        height: 60px;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        cursor: pointer;
        padding: 0;
    }
    
    .file-upload {
        border: 2px dashed var(--gray-300);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .file-upload input[type="file"] {
        width: 100%;
    }
    
    .file-upload:hover {
        border-color: var(--primary);
        background: rgba(245, 48, 3, 0.05);
    }
    
    .preview {
        margin: 1rem auto 0;
        width: 160px;
        min-height: 120px;
        border: 1px solid var(--gray-200);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
        background: var(--gray-50);
        overflow: hidden;
    }

    body.dark-mode .preview {
        background: var(--gray-700);
        border-color: var(--gray-600);
    }

    .preview.is-empty span {
        color: var(--text-light);
        font-size: 0.85rem;
        line-height: 1.35;
    }
    
    .preview img {
        max-width: 150px;
        max-height: 150px;
        border-radius: 10px;
        object-fit: contain;
    }

    .favicon-preview {
        width: 72px;
        min-height: 72px;
    }

    .favicon-preview img {
        max-width: 48px;
        max-height: 48px;
        border-radius: 6px;
    }

    .file-name {
        display: block;
        margin-top: 0.75rem;
        color: var(--text-light);
    }
    
    .suggested-amounts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 0.75rem;
    }
    
    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
    }
    
    .toggle-switch input[type="checkbox"] {
        width: 50px;
        height: 26px;
        appearance: none;
        background: var(--gray-300);
        border-radius: 50px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .toggle-switch input[type="checkbox"]:checked {
        background: var(--primary);
    }
    
    .toggle-switch input[type="checkbox"]::before {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 3px;
        transition: transform 0.3s ease;
    }
    
    .toggle-switch input[type="checkbox"]:checked::before {
        transform: translateX(24px);
    }
    
    .toggle-switch label {
        margin-bottom: 0;
        cursor: pointer;
    }
    
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-top: 0.5rem;
    }
    
    .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-weight: normal;
    }
    
    .payment-gateways {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .gateway-card {
        border: 1px solid var(--gray-200);
        border-radius: 15px;
        padding: 1.5rem;
    }
    
    body.dark-mode .gateway-card {
        border-color: var(--gray-700);
    }
    
    .gateway-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    body.dark-mode .gateway-header {
        border-color: var(--gray-700);
    }
    
    .gateway-settings {
        padding-left: 1rem;
    }

    .gateway-brand {
        display: inline-flex;
        align-items: center;
        min-height: 30px;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .paystack-brand {
        color: #0BA4DB;
        letter-spacing: 0.02em;
    }
    
    .backup-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .backup-option {
        background: var(--gray-50);
        border-radius: 15px;
        padding: 1.5rem;
    }
    
    body.dark-mode .backup-option {
        background: var(--gray-700);
    }
    
    .backup-option h4 {
        margin-bottom: 0.75rem;
        color: var(--text-dark);
    }
    
    body.dark-mode .backup-option h4 {
        color: white;
    }
    
    .backup-option p {
        color: var(--text-light);
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }
    
    .backup-list {
        margin-bottom: 2rem;
    }
    
    .backup-list h4,
    .import-export h4 {
        margin-bottom: 1rem;
        font-size: 1.125rem;
        color: var(--text-dark);
    }
    
    body.dark-mode .backup-list h4,
    body.dark-mode .import-export h4 {
        color: white;
    }
    
    .data-table {
        width: 100%;
        overflow-x: auto;
    }
    
    .data-table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th,
    .data-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }
    
    body.dark-mode .data-table th,
    body.dark-mode .data-table td {
        border-color: var(--gray-700);
    }
    
    .data-table th {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    body.dark-mode .data-table th {
        color: white;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }
    
    .btn-edit {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
    }
    
    .btn-edit:hover {
        background: #10B981;
        color: white;
    }
    
    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
    }
    
    .btn-delete:hover {
        background: #EF4444;
        color: white;
    }
    
    .export-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    
    .import-group {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .import-group .form-control {
        flex: 1;
        min-width: 200px;
    }
    
    .test-email {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .test-email .form-control {
        flex: 1;
        min-width: 250px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 48, 3, 0.3);
    }
    
    .btn-secondary {
        background: var(--gray-200);
        color: var(--gray-700);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    body.dark-mode .btn-secondary {
        background: var(--gray-700);
        color: var(--gray-300);
    }
    
    .btn-secondary:hover {
        background: var(--gray-300);
    }
    
    .form-actions {
        margin-top: 2rem;
        padding-top: 1rem;
        text-align: right;
        border-top: 1px solid var(--gray-200);
    }
    
    body.dark-mode .form-actions {
        border-color: var(--gray-700);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .settings-container {
            padding: 0 1rem;
        }
        
        .settings-card {
            padding: 1.5rem;
        }
        
        .tab-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .checkbox-group {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .export-options {
            flex-direction: column;
        }
        
        .import-group {
            flex-direction: column;
        }
        
        .import-group .form-control {
            width: 100%;
        }
        
        .test-email {
            flex-direction: column;
        }
        
        .test-email .form-control {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.settings-tabs .tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.dataset.tab;
                
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                this.classList.add('active');
                const targetPane = document.getElementById(targetId);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });

        document.querySelectorAll('.color-picker').forEach(picker => {
            const colorInput = picker.querySelector('input[type="color"]');
            const textInput = picker.querySelector('input[type="text"]');

            if (!colorInput || !textInput) {
                return;
            }

            colorInput.addEventListener('input', function () {
                textInput.value = this.value.toUpperCase();
            });

            textInput.addEventListener('input', function () {
                const value = this.value.trim();

                if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                    colorInput.value = value;
                    this.value = value.toUpperCase();
                }
            });
        });

        document.querySelectorAll('.file-upload input[type="file"]').forEach(input => {
            input.addEventListener('change', function () {
                const file = this.files && this.files[0];
                const upload = this.closest('.file-upload');
                const preview = upload ? upload.querySelector('.preview') : null;
                const image = preview ? preview.querySelector('img') : null;
                const placeholder = preview ? preview.querySelector('span') : null;
                const fileName = upload ? upload.querySelector('.file-name') : null;

                if (!preview || !image || !file) {
                    return;
                }

                if (image.dataset.previewUrl) {
                    URL.revokeObjectURL(image.dataset.previewUrl);
                }

                const previewUrl = URL.createObjectURL(file);
                image.dataset.previewUrl = previewUrl;
                image.src = previewUrl;
                image.hidden = false;
                preview.classList.remove('is-empty');

                if (placeholder) {
                    placeholder.hidden = true;
                }

                if (fileName) {
                    fileName.textContent = `${file.name} selected`;
                }
            });
        });
    });
    
    // Mock functions for backup actions
    function createBackup() {
        alert('Creating backup... This would trigger a database backup in production.');
    }
    
    function downloadBackup() {
        alert('Downloading backup... This would download the selected backup file.');
    }
    
    function deleteBackup() {
        if (confirm('Are you sure you want to delete this backup?')) {
            alert('Backup deleted successfully!');
        }
    }
    
    function restoreBackup() {
        if (confirm('Are you sure you want to restore this backup? This will overwrite current data.')) {
            alert('Backup restored successfully!');
        }
    }
    
    function exportData(type) {
        alert(`Exporting ${type} data... This would generate a CSV/Excel file in production.`);
    }
    
    function importData() {
        alert('Importing data... This would process the uploaded file in production.');
    }
    
    function sendTestEmail() {
        const email = document.querySelector('#email .test-email input').value;
        if (email) {
            alert(`Test email sent to ${email}!`);
        } else {
            alert('Please enter an email address.');
        }
    }
</script>
@endsection
