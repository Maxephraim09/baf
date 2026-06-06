@extends('layouts.app')

@section('title', 'Volunteer Registration - Join Our Mission')
@section('hideDefaultNavigation', true)

@section('content')
<style>
    .volunteer-page {
        background: linear-gradient(135deg, var(--bg-light) 0%, #f8fafc 100%);
        min-height: 100vh;
    }

    .volunteer-hero {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.62), rgba(0, 0, 0, 0.35)),
                    url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1800&h=700&fit=crop') center/cover;
        color: white;
        padding: 8rem 1.5rem 7rem;
        text-align: center;
    }

    .volunteer-hero h1 {
        font-size: clamp(2.25rem, 6vw, 4rem);
        font-weight: 800;
        margin: 0 auto 1rem;
        max-width: 900px;
    }

    .volunteer-hero p {
        font-size: 1.125rem;
        line-height: 1.8;
        margin: 0 auto;
        max-width: 720px;
        opacity: 0.95;
    }

    .volunteer-wrap {
        margin: -4rem auto 0;
        max-width: 1180px;
        padding: 0 1rem 4rem;
    }

    .volunteer-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(300px, 0.8fr);
        gap: 1.5rem;
        align-items: start;
    }

    .volunteer-panel,
    .info-panel {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
    }

    .volunteer-panel {
        padding: 2rem;
    }

    .info-panel {
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

    .form-group label .required {
        color: var(--primary);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font: inherit;
        padding: 0.85rem 1rem;
        width: 100%;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
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

    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .skill-tag {
        background: #f3f4f6;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        cursor: pointer;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .skill-tag.selected {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .skill-tag:hover {
        border-color: var(--primary);
    }

    .availability-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .availability-option {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        padding: 0.75rem;
        text-align: center;
        transition: all 0.2s ease;
    }

    .availability-option.selected {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .availability-option:hover {
        border-color: var(--primary);
    }

    .submit-volunteer {
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
        transition: filter 0.2s ease;
    }

    .submit-volunteer:hover {
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

    .notice.success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }

    .info-list {
        display: grid;
        gap: 1rem;
        margin: 1rem 0 1.5rem;
    }

    .info-item {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1rem;
    }

    .info-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-item strong {
        color: var(--primary);
        display: block;
        font-size: 1.5rem;
    }

    .benefits-list {
        background: #f9fafb;
        border-radius: 8px;
        line-height: 1.7;
        padding: 1rem;
    }

    .benefits-list ul,
    .benefits-list ol {
        margin: 0.5rem 0 0 1.25rem;
    }

    .benefits-list li {
        margin-bottom: 0.5rem;
    }

    @media (max-width: 900px) {
        .volunteer-grid,
        .form-grid {
            grid-template-columns: 1fr;
        }

        .info-panel {
            position: static;
        }
    }

    @media (max-width: 560px) {
        .volunteer-panel {
            padding: 1.25rem;
        }

        .availability-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@include('layouts.frontend-navigation')

<div class="volunteer-page">
    <section class="volunteer-hero">
        <h1>Become a Volunteer</h1>
        <p>Join our passionate team of volunteers and make a real difference in communities around the world. Your time, skills, and compassion can change lives.</p>
    </section>

    <div class="volunteer-wrap">
        <div class="volunteer-grid">
            <div class="volunteer-panel">
                <h2 class="section-title">Volunteer Registration Form</h2>

                @if(session('success'))
                    <div class="notice success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="notice error">
                        <ul style="margin-left: 1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('volunteer.store') }}" method="POST" id="volunteerRegistrationForm">
                    @csrf

                    <div class="form-grid">
                        <!-- Personal Information -->
                        <div class="form-group">
                            <label>Full Name <span class="required">*</span></label>
                            <input type="text" name="full_name" required value="{{ old('full_name') }}" placeholder="John Doe">
                        </div>

                        <div class="form-group">
                            <label>Email Address <span class="required">*</span></label>
                            <input type="email" name="email" required value="{{ old('email') }}" placeholder="john@example.com">
                        </div>

                        <div class="form-group">
                            <label>Phone Number <span class="required">*</span></label>
                            <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="+1 234 567 890">
                        </div>

                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="">Select</option>
                                <option value="male" @selected(old('gender') === 'male')>Male</option>
                                <option value="female" @selected(old('gender') === 'female')>Female</option>
                                <option value="other" @selected(old('gender') === 'other')>Other</option>
                                <option value="prefer_not" @selected(old('gender') === 'prefer_not')>Prefer not to say</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, City, Postal Code">
                        </div>

                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" value="{{ old('country') }}" placeholder="United States">
                        </div>

                        <!-- Interest Area -->
                        <div class="form-group">
                            <label>Area of Interest <span class="required">*</span></label>
                            <select name="interest_area" required>
                                <option value="">Select an area</option>
                                <option value="education" @selected(old('interest_area') === 'education')>Education & Teaching</option>
                                <option value="healthcare" @selected(old('interest_area') === 'healthcare')>Healthcare & Medical</option>
                                <option value="community" @selected(old('interest_area') === 'community')>Community Outreach</option>
                                <option value="fundraising" @selected(old('interest_area') === 'fundraising')>Fundraising & Events</option>
                                <option value="administration" @selected(old('interest_area') === 'administration')>Administration & Office</option>
                                <option value="technical" @selected(old('interest_area') === 'technical')>Technical & IT</option>
                                <option value="social_media" @selected(old('interest_area') === 'social_media')>Social Media & Marketing</option>
                                <option value="photography" @selected(old('interest_area') === 'photography')>Photography & Videography</option>
                                <option value="other" @selected(old('interest_area') === 'other')>Other</option>
                            </select>
                        </div>

                        <!-- Skills -->
                        <div class="form-group full">
                            <label>Skills (Select all that apply)</label>
                            <div class="skills-container" id="skillsContainer">
                                @php $selectedSkills = old('skills', []); @endphp
                                <div class="skill-tag {{ in_array('teaching', $selectedSkills) ? 'selected' : '' }}" data-skill="teaching">Teaching/Tutoring</div>
                                <div class="skill-tag {{ in_array('medical', $selectedSkills) ? 'selected' : '' }}" data-skill="medical">Medical/Nursing</div>
                                <div class="skill-tag {{ in_array('writing', $selectedSkills) ? 'selected' : '' }}" data-skill="writing">Writing/Editing</div>
                                <div class="skill-tag {{ in_array('design', $selectedSkills) ? 'selected' : '' }}" data-skill="design">Graphic Design</div>
                                <div class="skill-tag {{ in_array('coding', $selectedSkills) ? 'selected' : '' }}" data-skill="coding">Web Development</div>
                                <div class="skill-tag {{ in_array('social_media', $selectedSkills) ? 'selected' : '' }}" data-skill="social_media">Social Media</div>
                                <div class="skill-tag {{ in_array('fundraising', $selectedSkills) ? 'selected' : '' }}" data-skill="fundraising">Fundraising</div>
                                <div class="skill-tag {{ in_array('languages', $selectedSkills) ? 'selected' : '' }}" data-skill="languages">Foreign Languages</div>
                                <div class="skill-tag {{ in_array('driving', $selectedSkills) ? 'selected' : '' }}" data-skill="driving">Driving/Transport</div>
                                <div class="skill-tag {{ in_array('construction', $selectedSkills) ? 'selected' : '' }}" data-skill="construction">Construction/Labor</div>
                            </div>
                            <input type="hidden" name="skills" id="skillsInput" value="{{ old('skills') ? (is_array(old('skills')) ? implode(',', old('skills')) : old('skills')) : '' }}">
                        </div>

                        <!-- Experience Level -->
                        <div class="form-group">
                            <label>Experience Level</label>
                            <select name="experience_level">
                                <option value="">Select</option>
                                <option value="none" @selected(old('experience_level') === 'none')>No experience (willing to learn)</option>
                                <option value="beginner" @selected(old('experience_level') === 'beginner')>Beginner (some exposure)</option>
                                <option value="intermediate" @selected(old('experience_level') === 'intermediate')>Intermediate (practical experience)</option>
                                <option value="advanced" @selected(old('experience_level') === 'advanced')>Advanced (professional level)</option>
                                <option value="expert" @selected(old('experience_level') === 'expert')>Expert (can train others)</option>
                            </select>
                        </div>

                        <!-- Availability -->
                        <div class="form-group full">
                            <label>Availability <span class="required">*</span></label>
                            <div class="availability-grid" id="availabilityContainer">
                                @php $selectedAvailability = old('availability', []); @endphp
                                <div class="availability-option {{ in_array('weekdays', $selectedAvailability) ? 'selected' : '' }}" data-day="weekdays">Weekdays (Mon-Fri)</div>
                                <div class="availability-option {{ in_array('weekends', $selectedAvailability) ? 'selected' : '' }}" data-day="weekends">Weekends (Sat-Sun)</div>
                                <div class="availability-option {{ in_array('evenings', $selectedAvailability) ? 'selected' : '' }}" data-day="evenings">Evenings (After 5PM)</div>
                                <div class="availability-option {{ in_array('mornings', $selectedAvailability) ? 'selected' : '' }}" data-day="mornings">Mornings (Before 12PM)</div>
                                <div class="availability-option {{ in_array('flexible', $selectedAvailability) ? 'selected' : '' }}" data-day="flexible">Flexible Schedule</div>
                                <div class="availability-option {{ in_array('remote', $selectedAvailability) ? 'selected' : '' }}" data-day="remote">Remote/Virtual Only</div>
                            </div>
                            <input type="hidden" name="availability" id="availabilityInput" value="{{ old('availability') ? (is_array(old('availability')) ? implode(',', old('availability')) : old('availability')) : '' }}">
                        </div>

                        <!-- Commitment Duration -->
                        <div class="form-group">
                            <label>How long can you commit?</label>
                            <select name="commitment_duration">
                                <option value="">Select</option>
                                <option value="one_time" @selected(old('commitment_duration') === 'one_time')>One-time event</option>
                                <option value="1-3_months" @selected(old('commitment_duration') === '1-3_months')>1-3 months</option>
                                <option value="3-6_months" @selected(old('commitment_duration') === '3-6_months')>3-6 months</option>
                                <option value="6-12_months" @selected(old('commitment_duration') === '6-12_months')>6-12 months</option>
                                <option value="long_term" @selected(old('commitment_duration') === 'long_term')>Long-term (1+ years)</option>
                            </select>
                        </div>

                        <!-- Hours Per Week -->
                        <div class="form-group">
                            <label>Hours available per week</label>
                            <select name="hours_per_week">
                                <option value="">Select</option>
                                <option value="1-5" @selected(old('hours_per_week') === '1-5')>1-5 hours</option>
                                <option value="6-10" @selected(old('hours_per_week') === '6-10')>6-10 hours</option>
                                <option value="11-20" @selected(old('hours_per_week') === '11-20')>11-20 hours</option>
                                <option value="20+" @selected(old('hours_per_week') === '20+')>20+ hours</option>
                            </select>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="form-group">
                            <label>Emergency Contact Name</label>
                            <input type="text" name="emergency_name" value="{{ old('emergency_name') }}" placeholder="Full name">
                        </div>

                        <div class="form-group">
                            <label>Emergency Contact Phone</label>
                            <input type="tel" name="emergency_phone" value="{{ old('emergency_phone') }}" placeholder="Phone number">
                        </div>

                        <!-- Why Volunteer -->
                        <div class="form-group full">
                            <label>Why do you want to volunteer with us?</label>
                            <textarea name="motivation" rows="4" placeholder="Tell us about your passion for helping others...">{{ old('motivation') }}</textarea>
                        </div>

                        <!-- Additional Info -->
                        <div class="form-group full">
                            <label>Additional Information</label>
                            <textarea name="additional_info" rows="3" placeholder="Anything else you'd like us to know?">{{ old('additional_info') }}</textarea>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-group full">
                            <label class="checkbox-line">
                                <input type="checkbox" name="terms" value="1" required {{ old('terms') ? 'checked' : '' }}>
                                <span>I agree to the Volunteer Terms and Code of Conduct <span class="required">*</span></span>
                            </label>
                        </div>

                        <div class="form-group full">
                            <label class="checkbox-line">
                                <input type="checkbox" name="background_check_consent" value="1" {{ old('background_check_consent') ? 'checked' : '' }}>
                                <span>I consent to a background check if required for my volunteer role</span>
                            </label>
                        </div>

                        <div class="form-group full">
                            <label class="checkbox-line">
                                <input type="checkbox" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}>
                                <span>Subscribe me to volunteer newsletters and updates</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="submit-volunteer">
                        <i class="fas fa-hands-helping"></i>
                        Submit Volunteer Application
                    </button>
                </form>
            </div>

            <aside class="info-panel">
                <h2 class="section-title">Why Volunteer With Us?</h2>
                <div class="info-list">
                    <div class="info-item">
                        <strong>500+</strong>
                        <span>Active Volunteers Worldwide</span>
                    </div>
                    <div class="info-item">
                        <strong>15+</strong>
                        <span>Countries We Serve</span>
                    </div>
                    <div class="info-item">
                        <strong>50K+</strong>
                        <span>Lives Impacted Annually</span>
                    </div>
                </div>

                <div class="benefits-list">
                    <strong>✨ What You'll Gain</strong>
                    <ul>
                        <li>Make a tangible difference in communities</li>
                        <li>Develop new skills and gain experience</li>
                        <li>Meet like-minded passionate people</li>
                        <li>Receive volunteer certificate and recognition</li>
                        <li>Flexible schedules to fit your lifestyle</li>
                        <li>Training and support provided</li>
                    </ul>
                </div>

                <div class="benefits-list" style="margin-top: 1rem;">
                    <strong>📋 Next Steps After Applying</strong>
                    <ol>
                        <li>Our team reviews your application (2-3 business days)</li>
                        <li>You'll receive a welcome email with next steps</li>
                        <li>Orientation and training session scheduling</li>
                        <li>Get matched with a role that fits your skills</li>
                    </ol>
                </div>

                <div class="benefits-list" style="margin-top: 1rem; background: #fef3c7;">
                    <strong>❓ Questions?</strong>
                    <p style="margin-top: 0.5rem; font-size: 0.875rem;">Contact our Volunteer Coordinator at <strong>volunteer@agontara.org</strong> or call +1 234 567 890.</p>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
    // Skills Selection
    const skillsContainer = document.getElementById('skillsContainer');
    const skillsInput = document.getElementById('skillsInput');
    const availabilityContainer = document.getElementById('availabilityContainer');
    const availabilityInput = document.getElementById('availabilityInput');

    let selectedSkills = [];
    let selectedAvailability = [];

    function updateSkillsInput() {
        skillsInput.value = selectedSkills.join(',');
    }

    function updateAvailabilityInput() {
        availabilityInput.value = selectedAvailability.join(',');
    }

    if (skillsContainer) {
        // Initialize from old values
        const existingSkills = skillsInput.value;
        if (existingSkills) {
            selectedSkills = existingSkills.split(',').filter(s => s.trim());
        }

        document.querySelectorAll('.skill-tag').forEach(tag => {
            const skill = tag.dataset.skill;
            if (selectedSkills.includes(skill)) {
                tag.classList.add('selected');
            }

            tag.addEventListener('click', () => {
                const skillValue = tag.dataset.skill;
                if (tag.classList.contains('selected')) {
                    tag.classList.remove('selected');
                    selectedSkills = selectedSkills.filter(s => s !== skillValue);
                } else {
                    tag.classList.add('selected');
                    selectedSkills.push(skillValue);
                }
                updateSkillsInput();
            });
        });
    }

    if (availabilityContainer) {
        const existingAvailability = availabilityInput.value;
        if (existingAvailability) {
            selectedAvailability = existingAvailability.split(',').filter(a => a.trim());
        }

        document.querySelectorAll('.availability-option').forEach(option => {
            const day = option.dataset.day;
            if (selectedAvailability.includes(day)) {
                option.classList.add('selected');
            }

            option.addEventListener('click', () => {
                const dayValue = option.dataset.day;
                if (option.classList.contains('selected')) {
                    option.classList.remove('selected');
                    selectedAvailability = selectedAvailability.filter(a => a !== dayValue);
                } else {
                    option.classList.add('selected');
                    selectedAvailability.push(dayValue);
                }
                updateAvailabilityInput();
            });
        });
    }

    // Form validation
    const volunteerForm = document.getElementById('volunteerRegistrationForm');
    if (volunteerForm) {
        volunteerForm.addEventListener('submit', function(e) {
            if (selectedAvailability.length === 0) {
                e.preventDefault();
                alert('Please select at least one availability option.');
                return false;
            }

            const termsCheckbox = document.querySelector('input[name="terms"]');
            if (termsCheckbox && !termsCheckbox.checked) {
                e.preventDefault();
                alert('Please agree to the Volunteer Terms and Code of Conduct.');
                return false;
            }
        });
    }
</script>

@include('layouts.frontend-footer')

@endsection
