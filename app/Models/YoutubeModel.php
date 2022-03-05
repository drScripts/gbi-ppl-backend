<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeModel extends Model
{
    use HasFactory;


    protected $table = 'youtube';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'publishedAt',
        'category',
    ];


    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
