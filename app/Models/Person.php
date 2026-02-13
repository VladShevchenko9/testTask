<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

    public const DIRECTOR = 'director';
    public const WRITER = 'writer';
    public const ACTOR = 'actor';
    public const COMPOSER = 'composer';

    protected $fillable = [
        'name_ua',
        'name_en',
        'photo',
    ];
}
