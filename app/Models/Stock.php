<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer_id',
        't_user_id',
        'select',
        'sequence',
    ];

    public function answer() {
        return $this->belongsTo(Answer::class);
    }
}
