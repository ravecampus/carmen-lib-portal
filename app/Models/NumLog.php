<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumLog extends Model
{
    use HasFactory;
    protected $table = 'num_logs';
    protected $fillable =  ['user_id', 'log', 'date'];
}
