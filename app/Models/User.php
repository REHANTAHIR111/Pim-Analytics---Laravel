<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class User extends Authenticatable
{

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'date_of_birth',
        'gender',
        'password',
        'profile_image',
        'role_id',
        'status',
        'role',
        'creator_id',
    ];

    public function roleRelation() {
        return $this->belongsTo(Role::class, 'role', 'id');
    }
}
