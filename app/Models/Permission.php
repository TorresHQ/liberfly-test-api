<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'subject', 'action'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
