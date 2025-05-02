<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $table = 'research';
    protected $primaryKey = 'research_id';
    public $timestamps = false;

    protected $fillable = [
        'title', 'abstract', 'authors', 'fields', 'date_submitted',
        'date_approved', 'document', 'approved', 'status',
        'submitted_by', 'approved_by', 'last_updated', 'department', 'college'
    ];


    public function researcher()
    {
        return $this->belongsTo(Researcher::class, 'submitted_by');
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'approved_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'research_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'research_id');
    }
}
