<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'newsletter', 'status', 'admin_reply', 'replied_at'];

    protected $casts = ['newsletter' => 'boolean', 'replied_at' => 'datetime'];
}
