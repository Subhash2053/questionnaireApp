<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['title','expiry_date'];

     
    public function questions() {
        return $this->belongsToMany(Question::class,ExamQuestion::class);
    }

    public function scopeActive($query)
    {
        return $query->where('expiry_date','>', Carbon::now());
    }
}
