<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShapeResponse extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'shape_id',
        'image_response',
        'score'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function shape()
    {
        return $this->belongsTo(Shape::class);
    }
}
