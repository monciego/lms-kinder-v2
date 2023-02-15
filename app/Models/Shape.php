<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'instruction',
        'deadline',
        'image',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function shape_responses()
    {
        return $this->hasMany(ShapeResponse::class);
    }
}
