<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question','subject'];
    
    /**
     * Related Options
     **/
    public function options() {
        return $this->hasMany(Option::class, 'question_id');
    }

     /**
     * Specific answer
     **/
    public function answers() {
        return $this->belongsToMany(Option::class,Answer::class);
    }

}
