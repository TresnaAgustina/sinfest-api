<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Presale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'presale_name',
        'presale_start',
        'presale_end',
        'amount',
        'price',
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->getKey() == null) {
                $model->setAttribute($model->getKeyName(), Uuid::uuid4()->toString());
            }
        });
    }
}
