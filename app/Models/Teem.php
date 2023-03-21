<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teem extends Model
{
    use HasFactory;

    protected $fillable = [
        'teems_content',
        'author',
    ];
}
