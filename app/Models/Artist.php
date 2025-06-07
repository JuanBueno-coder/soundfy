<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Album;
use App\Models\Song;

class Artist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'image',
        'country',
        'genre',
    ];

    /**
     * Get all albums for this artist.
     */
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    /**
     * Get all songs for this artist through albums.
     */
    public function songs(): HasManyThrough
    {
        return $this->hasManyThrough(Song::class, Album::class);
    }

    /**
     * Scope to filter artists by genre.
     */
    public function scopeByGenre($query, string $genre)
    {
        return $query->where('genre', $genre);
    }

    /**
     * Scope to filter artists by country.
     */
    public function scopeByCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    /**
     * Get the artist's full display information.
     */
    public function getDisplayInfoAttribute(): array
    {
        return [
            'name' => $this->name,
            'genre' => $this->genre,
            'country' => $this->country,
            'albums_count' => $this->albums()->count(),
        ];
    }
}