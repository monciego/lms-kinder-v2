<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'grade_level_id',
        'subject_name',
        'start',
        'end',
    ];
    
    public function grade_level() 
    { 
        return $this->belongsTo(GradeLevel::class);
    }
    
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    
    public function activities() 
    { 
        return $this->hasMany(Activities::class);
    }
}
