<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'opportunity_id',
        'volunteer_id',
        'organization_id',
        'rating',
        'comment'
    ];

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }
}