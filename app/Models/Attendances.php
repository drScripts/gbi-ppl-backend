<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendances extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'attendances';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'schedule_id',
        'isAttendance',
        'persons',
        'unique_code'
    ];


    public function user()
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }

    public function schedule()
    {
        return $this->hasOne(Schedules::class, 'id', 'schedule_id');
    }

    public function scheduleAll()
    {
        return  $this->hasOne(Schedules::class, 'id', 'schedule_id')->withTrashed();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
