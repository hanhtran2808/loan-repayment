<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait Uuids
{
    /**
     * Boot function from laravel.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Str::uuid();
        });
    }
}