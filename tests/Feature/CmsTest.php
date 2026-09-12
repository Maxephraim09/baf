<?php

namespace Tests\Feature;

use App\Models\CmsSection;
use App\Models\Donation;
use App\Models\CmsContent;
use App\Models\ImpactLevel;
use App\Models\Project;
use App\Models\Partner;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized_users_cannot_access_cms(): void
    {
        $this->get('/admin/cms')->assertRedirect('/login');

        $user = User::factory()->create();
        $this->actingAs($user)->get('/admin/cms')->assertForbidden();
    }

    public function test_superadmin_can_access_cms(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));
        CmsSection::create(['key' => 'hero', 'name' => 'Hero', 'sort_order' => 1]);

        $this->actingAs($admin)->get('/admin/cms')->assertOk()->assertSee('Manage CMS');
    }

    public function test_homepage_uses_only_confirmed_project_donations(): void
    {
        CmsSection::create(['key' => 'projects', 'name' => 'Projects', 'sort_order' => 1]);
        $project = Project::create([
            'title' => 'Water project', 'description' => 'A project', 'goal_amount' => 1000,
            'location' => 'Nigeria', 'status' => 'active', 'is_active' => true,
        ]);

        Donation::create(['project_id' => $project->id, 'donor_name' => 'Paid', 'donor_email' => 'paid@example.com', 'amount' => 250, 'status' => 'successful']);
        Donation::create(['project_id' => $project->id, 'donor_name' => 'Pending', 'donor_email' => 'pending@example.com', 'amount' => 500, 'status' => 'pending']);
        Donation::create(['project_id' => $project->id, 'donor_name' => 'Refunded', 'donor_email' => 'refunded@example.com', 'amount' => 300, 'status' => 'refunded']);

        Cache::forget('homepage.cms');
        $this->get('/')->assertOk()->assertSee('250.00 raised')->assertSee('width: 25%');
    }

    public function test_homepage_keeps_core_values_summary_card_when_values_are_empty(): void
    {
        CmsSection::create(['key' => 'mission', 'name' => 'Mission', 'sort_order' => 1]);
        CmsSection::create(['key' => 'vision', 'name' => 'Vision', 'sort_order' => 2]);
        CmsSection::create(['key' => 'values', 'name' => 'Values', 'sort_order' => 3]);

        Cache::forget('homepage.cms');
        $this->get('/')->assertOk()->assertSee('Core Values')->assertSee('Compassion, integrity, empowerment');
    }

    public function test_admin_can_add_and_delete_about_values(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));
        $section = CmsSection::create(['key' => 'values', 'name' => 'Values', 'sort_order' => 1]);

        $response = $this->actingAs($admin)->post(route('admin.cms.sections.values.store', $section), [
            'title' => 'Empowerment',
            'description' => 'Creating lasting, self-sufficient solutions.',
            'sort_order' => 1,
            'is_active' => '1',
            'metadata' => ['icon' => 'fa-chart-line'],
        ]);

        $value = CmsContent::where('section_id', $section->id)->firstOrFail();
        $response->assertRedirect();
        $this->assertSame('Empowerment', $value->title);

        $this->actingAs($admin)->put(route('admin.cms.sections.values.update', [$section, $value]), [
            'title' => 'Community Empowerment',
            'description' => 'Updated value description.',
            'sort_order' => 2,
            'is_active' => '1',
        ])->assertRedirect();
        $this->assertDatabaseHas('cms_contents', [
            'id' => $value->id,
            'title' => 'Community Empowerment',
            'sort_order' => 2,
        ]);

        $this->actingAs($admin)->delete(route('admin.cms.sections.values.destroy', [$section, $value]))
            ->assertRedirect();
        $this->assertDatabaseMissing('cms_contents', ['id' => $value->id]);
    }

    public function test_update_only_tabs_hide_create_actions_and_show_delete_controls(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));

        $heroSection = CmsSection::create(['key' => 'hero', 'name' => 'Hero', 'sort_order' => 1]);
        $heroSection->contents()->create([
            'title' => 'Support the mission',
            'description' => 'Help us build brighter futures.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $impactLevel = ImpactLevel::create([
            'level' => 'Impact 1',
            'title' => 'Families supported',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $valuesSection = CmsSection::create(['key' => 'values', 'name' => 'Values', 'sort_order' => 2]);
        $value = $valuesSection->contents()->create([
            'title' => 'Compassion',
            'description' => 'We serve with care.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.cms.index', ['tab' => 'hero']))
            ->assertOk()
            ->assertSee('Update Section Title')
            ->assertDontSee('Add Hero')
            ->assertSee('> Update</a>', false)
            ->assertDontSee('> View</a>', false)
            ->assertDontSee('> Edit</a>', false);

        $this->actingAs($admin)
            ->get(route('admin.cms.index', ['tab' => 'hero', 'action' => 'edit']))
            ->assertOk()
            ->assertSee('Update only');

        $this->actingAs($admin)
            ->get(route('admin.cms.index', ['tab' => 'impact']))
            ->assertOk()
            ->assertSee(route('admin.cms.items.destroy', ['type' => 'impact', 'id' => $impactLevel->id]))
            ->assertSee('> View</a>', false)
            ->assertSee('> Edit</a>', false)
            ->assertSee('> Delete</button>', false);

        $this->actingAs($admin)
            ->get(route('admin.cms.index', ['tab' => 'values']))
            ->assertOk()
            ->assertSee(route('admin.cms.sections.values.destroy', [$valuesSection, $value]));
    }

    public function test_cms_create_forms_expose_the_fields_required_by_each_item_type(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));

        $forms = [
            'impact' => ['level', 'title'],
            'gallery' => ['title', 'caption', 'category', 'image'],
            'events' => ['title', 'description', 'event_date', 'location', 'status'],
            'testimonials' => ['author_name', 'role', 'testimonial', 'rating'],
            'team' => ['name', 'role', 'bio', 'image'],
            'info-cards' => ['badge', 'title', 'description', 'link_text', 'link_url'],
        ];

        foreach ($forms as $tab => $fields) {
            $response = $this->actingAs($admin)->get(route('admin.cms.index', [
                'tab' => $tab,
                'action' => 'create',
            ]));

            $response->assertOk();
            foreach ($fields as $field) {
                $response->assertSee('name="' . $field . '"', false);
            }
        }
    }

    public function test_values_edit_link_loads_the_value_form(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));
        $section = CmsSection::create(['key' => 'values', 'name' => 'Values', 'sort_order' => 1]);
        $value = $section->contents()->create([
            'title' => 'Compassion',
            'description' => 'We serve with care.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.cms.index', [
                'tab' => 'values',
                'action' => 'edit',
                'edit_type' => 'values',
                'edit' => $value->id,
            ]))
            ->assertOk()
            ->assertSee('value="Compassion"', false)
            ->assertSee('Save Value');
    }

    public function test_admin_can_manage_multiple_partners_and_homepage_renders_active_partners(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));
        CmsSection::create(['key' => 'partners', 'name' => 'Partners & Sponsors', 'sort_order' => 1]);

        $logo = UploadedFile::fake()->create('un-logo.png', 20, 'image/png');
        $response = $this->actingAs($admin)->post(route('admin.cms.items.store', 'partners'), [
            'name' => 'United Nations',
            'description' => 'Working together for lasting impact.',
            'sort_order' => 1,
            'is_active' => '1',
            'image' => $logo,
        ]);

        $response->assertRedirect();
        $partner = Partner::firstOrFail();
        $this->assertSame('United Nations', $partner->name);
        Storage::disk('public')->assertExists($partner->logo);

        $this->actingAs($admin)->get(route('admin.cms.index', ['tab' => 'partners', 'action' => 'create']))
            ->assertOk()
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="image"', false);

        $this->get(route('home'))->assertOk()->assertSee('United Nations')->assertSee('Working together for lasting impact.');
    }

    public function test_contact_form_persists_message_for_admin_inbox_and_reply(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe', 'email' => 'jane@example.com', 'subject' => 'partnership',
            'message' => 'I would like to partner with the foundation.',
        ]);

        $response->assertRedirect();
        $message = ContactMessage::firstOrFail();
        $this->assertSame('new', $message->status);
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin'));
        $this->actingAs($admin)->get(route('admin.messages.index'))->assertOk()->assertSee('Jane Doe');
        $this->actingAs($admin)->put(route('admin.messages.reply', $message), ['admin_reply' => 'Thank you for reaching out.'])->assertRedirect();
        $this->assertDatabaseHas('contact_messages', ['id' => $message->id, 'status' => 'replied']);
    }
}