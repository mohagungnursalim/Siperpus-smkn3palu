<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
}
