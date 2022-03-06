<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'full_name',
        'phone_number',
        'phone_number_verified_at',
        'cabang_id',
        'special_code',
        'picture_path',
        'address',
        'otp',
        'otp_exp',
        'isActive',
        'role',
        'password',
        'remember_token',
        'push_notif_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'push_notif_token',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getPicturePathAttribute($value)
    {
        return env("APP_URL") . "/" . "storage/" . $value;
    }

    public function region()
    {
        return $this->hasOne(Regions::class, 'id', 'cabang_id');
    }

    public function userVaccine()
    {
        return $this->hasMany(UsersVaccine::class, "user_id", "id");
    }

    public function attendance()
    {
        return $this->hasOne(Attendances::class, 'id', 'user_id');
    }

    /**
     * Undocumented function
     *
     * @param string|enum $roles ['user','admin','superadmin']
     * @return void
     */
    public function updateRoles(string $id, string $roles)
    {
        return Users::find($id)->update($roles);
    }
}
