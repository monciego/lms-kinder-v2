<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'image',
        'title',
        'deadline',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function puzzle_responses()
    {
        return $this->hasMany(PuzzleResponse::class);
    }
}
