<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'announcement';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cabang_id',
        'title',
        'description',
        'body',
        'image_path',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    public function region()
    {
        return $this->hasOne(Regions::class, 'id', 'cabang_id');
    }

    public function getImagePathAttribute($value)
    {
        return env("APP_URL") . "/" . "storage/" . $value;
    }
}
