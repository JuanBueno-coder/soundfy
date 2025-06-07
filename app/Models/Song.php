<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Album;
use App\Models\Playlist;

class Song extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'album_id',
        'track_number',
        'duration'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'duration' => 'datetime:H:i:s',
        'track_number' => 'integer',
    ];

    /**
     * Get the album that owns this song.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Get the playlists that contain this song.
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
                    ->withPivot('position')
                    ->withTimestamps();
    }

    /**
     * Get the artist through the album.
     */
    public function artist(): BelongsTo
    {
        return $this->album->artist();
    }

    /**
     * Scope to filter songs by album.
     */
    public function scopeFromAlbum($query, int $albumId)
    {
        return $query->where('album_id', $albumId);
    }

    /**
     * Scope to get short songs (under 3 minutes).
     */
    public function scopeShortSongs($query)
    {
        return $query->where('duration', '<=', '00:03:00');
    }

    /**
     * Scope to get long songs (over 5 minutes).
     */
    public function scopeLongSongs($query)
    {
        return $query->where('duration', '>=', '00:05:00');
    }

    /**
     * Get the song's display information.
     */
    public function getDisplayInfoAttribute(): array
    {
        return [
            'title' => $this->title,
            'artist' => $this->album->artist->name ?? 'Unknown Artist',
            'album' => $this->album->title ?? 'Unknown Album',
            'track_number' => $this->track_number,
            'duration' => $this->duration?->format('i:s'),
        ];
    }

    /**
     * Get formatted duration (3:45).
     */
    public function getFormattedDurationAttribute(): string
    {
        return $this->duration?->format('i:s') ?? '0:00';
    }
}