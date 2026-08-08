<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'read_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }

    public function isNew(): bool
    {
        return $this->status === 'new';
    }
}
