<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;
    protected $table = 'push_notification';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'token'
    ];

    protected $hidden = [
        'token',
    ];

    public function user()
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }
}
