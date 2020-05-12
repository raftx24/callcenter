<?php

namespace App\Models;

use App\Enums\CallStatus;
use App\Enums\CallPriority;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
        'phone_number', 'priority', 'support_id', 'status',
    ];

    public function support()
    {
        return $this->belongsTo(Support::class);
    }
    public function scopeImmediate($query)
    {
        $query->wherePriority(CallPriority::IMMEDIATE);
    }

    public function scopeWaiting($query)
    {
        $query->whereStatus(CallStatus::WAITING);
    }

    public function scopeOrdered($query)
    {
        $query->orderByRaw('priority, created_at');
    }

    public function isImmediate()
    {
        return (int) $this->priority === CallPriority::IMMEDIATE;
    }
}
