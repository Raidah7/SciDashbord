<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administrators';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'admin_level', 'department'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvedResearch()
    {
        return $this->hasMany(Research::class, 'approved_by');
    }
}
