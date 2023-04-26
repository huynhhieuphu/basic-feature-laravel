<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_full_name',
        'student_email',
        'student_phone',
        'student_course',
        'student_created_at',
        'student_updated_at'
    ];

    public $timestamps = false;
}
