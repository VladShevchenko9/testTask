<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $fillable = [
        'slug',
        'name_ua',
        'name_en',
    ];

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ua'
            ? $this->name_ua
            : $this->name_en;
    }

    public function films(): MorphToMany
    {
        return $this->morphedByMany(Film::class, 'taggable');
    }

    public function persons(): MorphToMany
    {
        return $this->morphedByMany(Person::class, 'taggable');
    }
}
