<?php

namespace App\Models;

use App\Enums\SupportStatus;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'name', 'priority', 'status'
    ];

    public function scopeFree($query)
    {
        $query->whereStatus(SupportStatus::WAITING);
    }


    public function scopeOrdered($query)
    {
        $query->orderBy('priority');
    }

    public function isFree()
    {
        return (int) $this->status === SupportStatus::WAITING;
    }
}
