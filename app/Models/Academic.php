<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;
    protected $table = 'academics';
    protected $fillable = ['subject'];

    public function academic_book()
    {
        return $this->hasMany(AcademicBook::class, 'academic_id', 'id')->with('book');
    }
}
