<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\FilmFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property boolean status
 * @property string title_ua
 * @property string title_en
 * @property string description_ua
 * @property string description_en
 * @property string poster
 * @property string screenshots
 * @property string trailer
 * @property Carbon release_date
 * @property Carbon start_date
 * @property Carbon end_date
 */
class Film extends Model
{
    /** @use HasFactory<FilmFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'status',
        'title_ua',
        'title_en',
        'description_ua',
        'description_en',
        'poster',
        'screenshots',
        'trailer',
        'release_date',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'release_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'screenshots' => 'array',
    ];

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        if ($locale == 'ua') {
            return $this->title_ua;
        }

        return $this->title_en;
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_person')
            ->withPivot(['role'])
            ->orderByDesc('film_person.id');
    }

    public function directors(): BelongsToMany
    {
        return $this->persons()->wherePivot('role', Person::DIRECTOR);
    }

    public function writers(): BelongsToMany
    {
        return $this->persons()->wherePivot('role', Person::WRITER);
    }

    public function actors(): BelongsToMany
    {
        return $this->persons()->wherePivot('role', Person::ACTOR);
    }

    public function composers(): BelongsToMany
    {
        return $this->persons()->wherePivot('role', Person::COMPOSER);
    }
}
