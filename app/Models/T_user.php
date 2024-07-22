<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;

class T_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'idno',
        'name',
        'name_kana',
        'position',
        'email',
        'year',
        'counter',
        'pass_fail',
    ];

    //ユーザー登録
    public function scopeCreateUser($query,$request) {
        return $query->create([
            'idno' => $request->idno,
            'name' => $request->name,
            'name_kana' => $request->name_kana,
            'position' => $request->position,
            'email' => $request->email,
            'year' => Setting::first()->year,
        ]);
    }
}
