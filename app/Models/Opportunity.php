<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $fillable = ['title', 'description', 'organization_id', 'volunteer_id', 'completed'];

    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
}