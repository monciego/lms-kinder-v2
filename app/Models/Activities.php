<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
        'activity_instruction',
        'activity_name',
        'activity_file',
        'activity_details'
    ];
    
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
