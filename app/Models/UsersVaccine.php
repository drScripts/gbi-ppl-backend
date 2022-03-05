<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersVaccine extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'users_vaccines';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'path_image',
        'vaccine_date',
        'description',
        'deleted_at',
        'updated_at',
        'created_at',
    ];
}
