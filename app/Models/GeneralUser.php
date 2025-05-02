<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralUser extends Model
{
    protected $table = 'generalusers';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'membership_level', 'points'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
