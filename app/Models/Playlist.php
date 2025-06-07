<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Song;

class Playlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'is_public'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get the user that owns this playlist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all songs in this playlist.
     */
    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class, 'playlist_song')
                    ->using(PlaylistSong::class) 
                    ->withPivot('position', 'created_at')
                    ->withTimestamps()
                    ->orderBy('pivot_position');
    }

    /**
     * Scope to get only public playlists.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope to filter playlists by user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get recent playlists.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Add a song to this playlist.
     */
    public function addSong(Song $song, ?int $position = null): void
    {
        $position = $position ?? ($this->songs()->max('pivot_position') + 1);
        
        $this->songs()->attach($song->id, [
            'position' => $position,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Remove a song from this playlist.
     */
    public function removeSong(Song $song): void
    {
        $this->songs()->detach($song->id);
    }

    /**
     * Get total duration of all songs in playlist.
     */
    public function getTotalDurationAttribute(): string
    {
        $totalSeconds = $this->songs->sum(function ($song) {
            return $song->duration?->hour * 3600 + 
                   $song->duration?->minute * 60 + 
                   $song->duration?->second ?? 0;
        });

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        
        return $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";
    }

    /**
     * Get the playlist's display information.
     */
    public function getDisplayInfoAttribute(): array
    {
        return [
            'name' => $this->name,
            'owner' => $this->user->name ?? 'Unknown User',
            'songs_count' => $this->songs()->count(),
            'is_public' => $this->is_public,
            'total_duration' => $this->total_duration,
            'created_at' => $this->created_at?->diffForHumans(),
        ];
    }
}