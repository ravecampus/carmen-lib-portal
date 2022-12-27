<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibProfile extends Model
{
    use HasFactory;

    protected $table = 'lib_profile';
    protected $fillable = [
        'image', 
        'title', 
        'description', 
        'history', 
        'mission',
        'vision',
        'rules_regulation'
    ];
}
