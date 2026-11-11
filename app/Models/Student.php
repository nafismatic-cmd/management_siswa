<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nis', 'nama', 'email', 'jenis_kelamin',
        'tanggal_lahir', 'kelas', 'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}