<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Testimonial;
use App\Models\User;

class Opportunity extends Model
{
    protected $fillable = ['title', 'description', 'organization_id', 'volunteer_id', 'completed', 'completed_at', 'points'];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class, 'opportunity_id');
    }
}