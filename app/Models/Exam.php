<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'exam_start',
        'exam_end',
        'duration',
        'created_by',
    ];

    public function getQuestion()
    {
        return $this->hasMany(ExamQuestion::class,'exam_id','id');
    }
}
