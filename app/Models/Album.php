<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Artist;
use App\Models\Song;

class Album extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'release_date',
        'genre',
        'cover_image',
        'description'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'release_date' => 'date',
    ];

    /**
     * Get the artist that owns this album.
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get all songs for this album.
     */
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    /**
     * Scope to filter albums by genre.
     */
    public function scopeByGenre($query, string $genre)
    {
        return $query->where('genre', $genre);
    }

    /**
     * Scope to filter albums by release year.
     */
    public function scopeByYear($query, int $year)
    {
        return $query->whereYear('release_date', $year);
    }

    /**
     * Scope to get recent albums.
     */
    public function scopeRecent($query, int $months = 6)
    {
        return $query->where('release_date', '>=', now()->subMonths($months));
    }

    /**
     * Get the album's display information.
     */
    public function getDisplayInfoAttribute(): array
    {
        return [
            'title' => $this->title,
            'artist' => $this->artist->name ?? 'Unknown Artist',
            'genre' => $this->genre,
            'release_year' => $this->release_date?->year,
            'songs_count' => $this->songs()->count(),
        ];
    }
}
