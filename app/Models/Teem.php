<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Teem extends Model
{
    use HasFactory;

    protected $fillable = [
        'teems_content',
        'author',
    ];

    public function writer(): BelongsTo{
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
