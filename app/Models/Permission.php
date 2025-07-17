<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\Role;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permission';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'role_id',
        'module_id',
        'view',
        'view_all',
        'create',
        'edit',
        'delete',
    ];

    public function module(){
        return $this->belongsTo(Module::class, 'module_id');
    }
}
