<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer_1',
        'answer_2',
        'answer_3',
        'correct',
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function stock() {
        return $this->hasOne(Stock::class);
    }
}
