<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'grade',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    
    public function shapes()
    {
        return $this->hasMany(Shape::class);
    }
    
    public function results()
    {
        return $this->hasMany(Result::class);
    }
    
    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
    
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    
    public function shape_responses()
    {
        return $this->hasMany(ShapeResponse::class);
    }
    
    public function puzzles()
    {
        return $this->hasMany(Puzzle::class);
    }
    
    public function puzzle_responses()
    {
        return $this->hasMany(PuzzleResponse::class);
    }
    
    public function parent_information()
    {
        return $this->hasOne(ParentInformation::class);
    }
    
    public function grade_levels() 
    { 
        return $this->hasMany(GradeLevel::class);
    }
    
    public function activities() 
    { 
        return $this->hasMany(Activities::class);
    }
}
