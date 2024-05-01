<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Like extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
