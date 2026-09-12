<?php

namespace Database\Seeders;

use App\Models\BoardMember;
use App\Models\CmsSection;
use App\Models\GalleryItem;
use App\Models\ImpactLevel;
use App\Models\InfoCard;
use App\Models\LandingEvent;
use App\Models\Partner;
use App\Models\Project;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['superadmin', 'donor', 'volunteer', 'beneficiary'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        foreach ([
            ['Admin User', 'admin@example.com', 'superadmin'],
            ['Demo Donor', 'donor@example.com', 'donor'],
            ['Demo Volunteer', 'volunteer@example.com', 'volunteer'],
            ['Demo Beneficiary', 'beneficiary@example.com', 'beneficiary'],
        ] as [$name, $email, $roleName]) {
            $user = User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
            $user->syncRoles([$roleName]);
        }

        foreach ([
            ['clean-water-initiative', 'Clean Water Initiative', 'Providing clean water to rural communities', 100000, 'Africa'],
            ['school-building-project', 'School Building Project', 'Building schools for underprivileged children', 150000, 'Asia'],
        ] as [$slug, $title, $description, $goal, $location]) {
            Project::updateOrCreate(['slug' => $slug], [
                'title' => $title,
                'description' => $description,
                'goal_amount' => $goal,
                'location' => $location,
                'status' => 'active',
                'is_active' => true,
            ]);
        }

        $sectionDefinitions = [
            ['hero', 'Hero', 10], ['about', 'About', 20], ['mission', 'Mission', 30],
            ['vision', 'Vision', 40], ['values', 'Values', 50], ['impact', 'Impact Statistics', 60],
            ['projects', 'Projects', 70], ['gallery', 'Gallery', 80], ['events', 'Events', 90],
            ['testimonials', 'Testimonials', 100], ['team', 'Team', 110], ['blog', 'Blog / News', 120],
            ['volunteer', 'Volunteer', 130], ['info-cards', 'Info Cards', 140],
            ['memorial-banner', 'Memorial Banner', 150], ['donate-impact', 'Donation Impact', 160],
            ['partners', 'Partners & Sponsors', 170], ['cta', 'Call to Action', 180],
        ];

        foreach ($sectionDefinitions as [$key, $name, $sortOrder]) {
            CmsSection::updateOrCreate(['key' => $key], ['name' => $name, 'sort_order' => $sortOrder, 'is_enabled' => true]);
        }

        $singleContent = [
            'hero' => ['title' => 'Honoring Legacy, Building Hope', 'description' => 'We empower communities through education, healthcare, and sustainable development.', 'button_text' => 'Donate Now', 'button_link' => '/donate'],
            'about' => ['title' => 'Our History', 'description' => 'Agontara Foundation builds on a legacy of service by investing in people and resilient communities.'],
            'mission' => ['title' => 'Our Mission', 'subtitle' => 'Guiding principles that drive our mission forward', 'description' => 'To empower communities with practical resources, opportunity, and compassionate support.'],
            'vision' => ['title' => 'Our Vision', 'description' => 'A just and thriving future where every person can live with dignity and possibility.'],
            'volunteer' => ['title' => 'Become a Volunteer', 'description' => 'Join our passionate team and use your skills and time to transform lives.', 'button_text' => 'Register as a Volunteer', 'button_link' => '/volunteer'],
            'memorial-banner' => ['title' => 'In Memory of Bishop Agontara', 'subtitle' => 'His Legacy Lives On', 'description' => 'We continue his commitment to preventable health care challenges and community service.', 'button_text' => 'Continue His Mission', 'button_link' => '/donate'],
            'cta' => ['title' => 'Ready to Make a Difference?', 'description' => 'Your donation, no matter the size, can change lives', 'button_text' => 'Donate Today', 'button_link' => '/donate'],
        ];

        foreach ($singleContent as $key => $data) {
            CmsSection::where('key', $key)->first()?->contents()->updateOrCreate(['sort_order' => 0], $data + ['is_active' => true]);
        }

        $impactSection = CmsSection::where('key', 'donate-impact')->first();
        foreach ([
            ['$25', 'Learning supplies', 'Provides learning supplies for a child in our education program', 'fa-child'],
            ['$50', 'Community screening', 'Supports a diabetes screening and education session for a community', 'fa-heartbeat'],
            ['$100', 'Essential medication', 'Provides essential medications for families in need', 'fa-pills'],
            ['$250', 'Skills training', 'Sponsors a woman\'s skills training program', 'fa-female'],
        ] as $index => [$amount, $title, $description, $icon]) {
            $impactSection?->contents()->updateOrCreate(['sort_order' => $index + 1], ['title' => $title, 'description' => $description, 'metadata' => compact('amount', 'icon'), 'is_active' => true]);
        }

        foreach ([['12', 'Active Projects'], ['2,500+', 'Lives Reached'], ['18', 'Communities Supported']] as $index => [$level, $title]) {
            ImpactLevel::updateOrCreate(['sort_order' => $index + 1], compact('level', 'title') + ['is_active' => true]);
        }

        LandingEvent::updateOrCreate(['title' => 'Volunteer Training Day'], ['description' => 'Learn how you can contribute to our mission.', 'event_date' => now()->addMonth()->setTime(10, 0), 'location' => 'Community Center', 'status' => 'upcoming', 'sort_order' => 1, 'is_active' => true]);
        Testimonial::updateOrCreate(['author_name' => 'Sarah Johnson'], ['role' => 'Community Leader', 'testimonial' => 'Agontara Foundation transformed our community through practical support and care.', 'sort_order' => 1, 'is_active' => true]);
        TeamMember::updateOrCreate(['name' => 'Agontara Leadership Team'], ['role' => 'Foundation Team', 'bio' => 'A dedicated team working alongside communities for lasting impact.', 'sort_order' => 1, 'is_active' => true]);
        InfoCard::updateOrCreate(['title' => 'Healthcare Initiative'], ['badge' => 'Featured', 'description' => 'Affordable, accessible healthcare for the communities we serve.', 'link_text' => 'Learn More', 'link_url' => '/about', 'sort_order' => 1, 'is_active' => true]);
        Partner::updateOrCreate(['name' => 'Community Partners'], ['description' => 'Together we create lasting impact.', 'logo' => 'https://placehold.co/240x100/png?text=Partner', 'sort_order' => 1, 'is_active' => true]);
        BoardMember::updateOrCreate(['name' => 'Board Leadership'], ['role' => 'Board of Trustees', 'bio' => 'Guiding the foundation with integrity, accountability, and care.', 'sort_order' => 1, 'is_active' => true]);
    }
}
