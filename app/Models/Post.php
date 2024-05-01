<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'image', 'status', 'created_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function commentList()
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

}
