<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicBook extends Model
{
    use HasFactory;
    protected $table = 'academic_books';
    protected $fillable = ['book_id', 'academic_id'];
    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id');
    }
}
