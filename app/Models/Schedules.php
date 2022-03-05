<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedules extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'schedules';
    protected $primaryKey = 'id';

    protected $fillable = [
        'date_event',
        'cabang_id',
        'current_people',
        'max_people',
        'event_begin',
        'event_end',
    ];

    public function region()
    {
        return $this->hasOne(Regions::class, 'id', 'cabang_id');
    }

    public static function addCurrentPeople($id, $people)
    {
        $schedule = Schedules::find($id);

        if (($schedule->current_people + $people) > $schedule->max_people) throw new Exception("Can't add any persons anymore", 400);

        $schedule->current_people += $people;
        $schedule->save();
    }
}
