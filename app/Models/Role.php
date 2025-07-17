<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\User;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
        'creator_id',
    ];
    protected $table = 'role';
    protected $primaryKey = 'id';

    public function permissions(){
        return $this->hasMany(Permission::class);
    }

    // public function users() {
    //     return $this->hasMany(User::class, 'role', 'id');
    // }
}
