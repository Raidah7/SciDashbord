<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'research_id', 'content', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function research()
    {
        return $this->belongsTo(Research::class, 'research_id');
    }
}
