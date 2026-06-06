<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class VolunteerController extends Controller
{
    /**
     * Display the volunteer registration page
     */
    public function index()
    {
        return view('frontend.volunteer');
    }

    /**
     * Store a new volunteer registration
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                // Personal Information
                'full_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:volunteers,email'],
                'phone' => ['required', 'string', 'max:50'],
                'date_of_birth' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'string', 'in:male,female,other,prefer_not'],
                'address' => ['nullable', 'string', 'max:500'],
                'country' => ['nullable', 'string', 'max:100'],
                
                // Volunteer Specific
                'interest_area' => ['required', 'string', 'in:education,healthcare,community,fundraising,administration,technical,social_media,photography,other'],
                'skills' => ['nullable', 'string', 'max:500'],
                'experience_level' => ['nullable', 'string', 'in:none,beginner,intermediate,advanced,expert'],
                'availability' => ['required', 'string', 'max:255'],
                'commitment_duration' => ['nullable', 'string', 'in:one_time,1-3_months,3-6_months,6-12_months,long_term'],
                'hours_per_week' => ['nullable', 'string', 'in:1-5,6-10,11-20,20+'],
                
                // Emergency Contact
                'emergency_name' => ['nullable', 'string', 'max:255'],
                'emergency_phone' => ['nullable', 'string', 'max:50'],
                
                // Additional Information
                'motivation' => ['nullable', 'string', 'max:5000'],
                'additional_info' => ['nullable', 'string', 'max:5000'],
                
                // Legal
                'terms' => ['required', 'accepted'],
                'background_check_consent' => ['nullable', 'boolean'],
                'newsletter' => ['nullable', 'boolean'],
            ]);

            // Create volunteer record
            $volunteer = Volunteer::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'country' => $validated['country'] ?? null,
                'interest_area' => $validated['interest_area'],
                'skills' => $validated['skills'] ?? null,
                'experience_level' => $validated['experience_level'] ?? null,
                'availability' => $validated['availability'],
                'commitment_duration' => $validated['commitment_duration'] ?? null,
                'hours_per_week' => $validated['hours_per_week'] ?? null,
                'emergency_name' => $validated['emergency_name'] ?? null,
                'emergency_phone' => $validated['emergency_phone'] ?? null,
                'motivation' => $validated['motivation'] ?? null,
                'additional_info' => $validated['additional_info'] ?? null,
                'background_check_consent' => $validated['background_check_consent'] ?? false,
                'newsletter' => $validated['newsletter'] ?? false,
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send confirmation email to volunteer
            try {
                Mail::send('emails.volunteer-confirmation', ['volunteer' => $volunteer], function ($message) use ($volunteer) {
                    $message->to($volunteer->email)
                            ->subject('Thank you for applying to volunteer with Agontara Foundation');
                });
            } catch (\Exception $e) {
                Log::error('Failed to send volunteer confirmation email: ' . $e->getMessage());
            }

            // Send notification to admin
            try {
                Mail::send('emails.volunteer-admin-notification', ['volunteer' => $volunteer], function ($message) {
                    $message->to(config('mail.admin_email', 'admin@agontara.org'))
                            ->subject('New Volunteer Application Received');
                });
            } catch (\Exception $e) {
                Log::error('Failed to send admin notification email: ' . $e->getMessage());
            }

            return redirect()->route('volunteer.success')
                ->with('success', 'Thank you for your volunteer application! Our team will review your information and contact you within 2-3 business days.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Volunteer registration error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Sorry, there was an error processing your application. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Display volunteer success page
     */
    public function success()
    {
        return view('frontend.volunteer-success');
    }

    /**
     * Display all volunteers (Admin only - can be moved to Admin controller)
     */
    public function indexAdmin()
    {
        $volunteers = Volunteer::orderBy('created_at', 'desc')->paginate(20);
        $stats = [
            'total' => Volunteer::count(),
            'pending' => Volunteer::where('status', 'pending')->count(),
            'accepted' => Volunteer::where('status', 'accepted')->count(),
            'rejected' => Volunteer::where('status', 'rejected')->count(),
        ];
        return view('admin.volunteers.index', compact('volunteers', 'stats'));
    }

    /**
     * Show specific volunteer details (Admin only)
     */
    public function show($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        return view('admin.volunteers.show', compact('volunteer'));
    }

    /**
     * Update volunteer status (Admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,reviewed,accepted,rejected'],
            'review_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $volunteer = Volunteer::findOrFail($id);
        $volunteer->status = $request->status;
        $volunteer->review_notes = $request->review_notes;
        $volunteer->reviewed_at = now();
        $volunteer->save();

        // Send status update email to volunteer
        if (in_array($request->status, ['accepted', 'rejected'])) {
            try {
                Mail::send('emails.volunteer-status-update', ['volunteer' => $volunteer], function ($message) use ($volunteer) {
                    $message->to($volunteer->email)
                            ->subject('Update on your volunteer application - Agontara Foundation');
                });
            } catch (\Exception $e) {
                Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Volunteer status updated successfully.');
    }

    /**
     * Export volunteers to CSV (Admin only)
     */
    public function export()
    {
        $volunteers = Volunteer::orderBy('created_at', 'desc')->get();
        
        $filename = 'volunteers_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($handle, [
            'ID', 'Full Name', 'Email', 'Phone', 'Date of Birth', 'Gender', 'Country',
            'Interest Area', 'Skills', 'Experience Level', 'Availability', 'Commitment',
            'Hours/Week', 'Status', 'Applied Date', 'Reviewed Date'
        ]);
        
        // Add data rows
        foreach ($volunteers as $volunteer) {
            fputcsv($handle, [
                $volunteer->id,
                $volunteer->full_name,
                $volunteer->email,
                $volunteer->phone,
                $volunteer->date_of_birth,
                $volunteer->gender,
                $volunteer->country,
                $volunteer->interest_area,
                $volunteer->skills,
                $volunteer->experience_level,
                $volunteer->availability,
                $volunteer->commitment_duration,
                $volunteer->hours_per_week,
                $volunteer->status,
                $volunteer->created_at,
                $volunteer->reviewed_at,
            ]);
        }
        
        fclose($handle);
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->stream(function() use ($volunteers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Full Name', 'Email', 'Phone', 'Date of Birth', 'Gender', 'Country',
                'Interest Area', 'Skills', 'Experience Level', 'Availability', 'Commitment',
                'Hours/Week', 'Status', 'Applied Date', 'Reviewed Date'
            ]);
            foreach ($volunteers as $volunteer) {
                fputcsv($handle, [
                    $volunteer->id,
                    $volunteer->full_name,
                    $volunteer->email,
                    $volunteer->phone,
                    $volunteer->date_of_birth,
                    $volunteer->gender,
                    $volunteer->country,
                    $volunteer->interest_area,
                    $volunteer->skills,
                    $volunteer->experience_level,
                    $volunteer->availability,
                    $volunteer->commitment_duration,
                    $volunteer->hours_per_week,
                    $volunteer->status,
                    $volunteer->created_at,
                    $volunteer->reviewed_at,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Delete volunteer record (Admin only)
     */
    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();
        
        return redirect()->route('admin.volunteers.index')
            ->with('success', 'Volunteer record deleted successfully.');
    }
}