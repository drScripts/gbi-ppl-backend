<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Khotbah extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'khotbah';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cabang_id',
        'title',
        'image_path',
        'pembawa',
        'bahan',
        'khotbah',
        'khotbah_date',
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
