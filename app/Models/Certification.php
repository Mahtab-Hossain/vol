<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'opportunity_id', 
        'user_id', 
        'organization_id', 
        'title', 
        'message', 
        'approved', 
        'pdf_path'
    ];

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }
}