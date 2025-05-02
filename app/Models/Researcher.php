<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Researcher extends Model
{
    protected $table = 'researchers';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'institution', 'expertise', 'research_count'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function research()
    {
        return $this->hasMany(Research::class, 'submitted_by');
    }
}
