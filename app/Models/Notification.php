<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $timestamps = false;

    protected $fillable = ['content', 'date', 'is_read', 'user_id', 'type', 'related_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
