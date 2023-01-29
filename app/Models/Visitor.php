<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class Visitor extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password'
    ];

    protected $primaryKey = "uuid";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guard = 'visitors';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->getKey() == null) {
                $model->setAttribute($model->getKeyName(), Uuid::uuid4()->toString());
            }
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
