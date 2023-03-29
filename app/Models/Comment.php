<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teem_id',
        'user_id',
        'parent_id',
        'comment',
        'image'
    ];

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commentator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username');
    }

    public function commentable() : MorphTo{

        return $this->morphTo();

    }


    public function replies() : HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }

    public function reply($attributes)
    {
        $reply = new Comment($attributes);
        $reply->user_id = auth()->id(); // Set user_id dari user yang sedang login
        $reply->parent_id = $this->id; // Set parent_id dari komentar ini
        $reply->save();

        return $reply;
    }
}
