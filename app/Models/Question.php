<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'quiz_id',
        'question',
        'image',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'key_answer',
    ];
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
