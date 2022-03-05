<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regions extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'regions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'unique_code',
        'maps_link',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public static function findRegion($id)
    {
        return Regions::find($id);
    }
}
