<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_name',
        'ticket_code',
        'order_uuid',
        'unique_code',
        'is_check_in',
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
