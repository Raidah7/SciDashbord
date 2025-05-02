<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'report_id';
    public $timestamps = false;

    protected $fillable = ['report_type', 'content', 'date_generated', 'generated_by', 'status', 'file_path'];

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
