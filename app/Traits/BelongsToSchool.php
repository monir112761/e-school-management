<?php

namespace App\Traits;

use App\Models\School;

trait BelongsToSchool
{
    public static function bootBelongsToSchool()
    {
        static::creating(function ($model) {
            if (auth()->check() && !$model->school_id) {
                $model->school_id = auth()->user()->school_id;
            }
        });

        static::addGlobalScope('school', function ($query) {
            if (auth()->check() && auth()->user()->role !== 'super_admin') {
                $query->where('school_id', auth()->user()->school_id);
            }
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
