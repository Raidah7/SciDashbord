<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    public $timestamps = false;

    protected $fillable = ['user_id', 'research_id', 'rating_value', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function research()
    {
        return $this->belongsTo(Research::class, 'research_id');
    }
}
