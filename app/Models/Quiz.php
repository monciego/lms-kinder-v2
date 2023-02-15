<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
        'quiz_name',
        'instruction',
        'deadline',
        'category',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
