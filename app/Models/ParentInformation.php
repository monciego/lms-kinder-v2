<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'mothers_name',
        'fathers_name',
        'contact_no',
        'address',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
