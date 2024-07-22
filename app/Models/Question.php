<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'num',
        'question',
        'year',
        'num',
    ];

    public function answer() {
        return $this->hasOne(Answer::class);
    }
}
