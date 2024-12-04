<?php

// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Add the fields that are mass-assignable
    protected $fillable = [
        'title',
        'content',
        'status',
        'image',
    ];
}
