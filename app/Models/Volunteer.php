<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $table = 'volunteers';
    
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'country',
        'interest_area',
        'skills',
        'experience_level',
        'availability',
        'commitment_duration',
        'hours_per_week',
        'emergency_name',
        'emergency_phone',
        'motivation',
        'additional_info',
        'background_check_consent',
        'newsletter',
        'status',
        'ip_address',
        'user_agent',
        'review_notes',
        'reviewed_at',
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'background_check_consent' => 'boolean',
        'newsletter' => 'boolean',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Accessor for formatted date
    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('F j, Y') : 'Not provided';
    }
    
    // Accessor for status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'reviewed' => '<span class="badge badge-info">Reviewed</span>',
            'accepted' => '<span class="badge badge-success">Accepted</span>',
            'rejected' => '<span class="badge badge-danger">Rejected</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }
    
    // Scope for pending volunteers
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    // Scope for accepted volunteers
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
    
    // Scope for newsletter subscribers
    public function scopeNewsletterSubscribers($query)
    {
        return $query->where('newsletter', true);
    }
}