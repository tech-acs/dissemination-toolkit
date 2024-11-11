<?php

namespace Uneca\DisseminationToolkit\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function getIsExpiredAttribute()
    {
        return $this->expires_at->isPast();
    }

    public function getStatusAttribute()
    {
        return $this->expires_at->isPast() ? "Expired" : "Expires in " . $this->expires_at->diffForHumans(['parts' => 3, 'syntax' => CarbonInterface::DIFF_ABSOLUTE]);
    }
}
