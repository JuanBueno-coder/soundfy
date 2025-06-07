<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistSong extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'playlist_song';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'playlist_id',
        'song_id',
        'position'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'position' => 'integer',
    ];

    /**
     * Get the playlist this entry belongs to.
     */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    /**
     * Get the song this entry belongs to.
     */
    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    /**
     * Scope to order by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    /**
     * Scope to filter by playlist.
     */
    public function scopeForPlaylist($query, int $playlistId)
    {
        return $query->where('playlist_id', $playlistId);
    }

    /**
     * Get the next position for a playlist.
     */
    public static function getNextPosition(int $playlistId): int
    {
        return self::where('playlist_id', $playlistId)->max('position') + 1;
    }

    /**
     * Reorder songs in a playlist.
     */
    public static function reorderPlaylist(int $playlistId, array $songOrder): void
    {
        foreach ($songOrder as $position => $songId) {
            self::where('playlist_id', $playlistId)
                ->where('song_id', $songId)
                ->update(['position' => $position + 1]);
        }
    }

    /**
     * Move song to new position.
     */
    public function moveToPosition(int $newPosition): void
    {
        $oldPosition = $this->position;
        $playlistId = $this->playlist_id;

        if ($newPosition === $oldPosition) {
            return;
        }

        // Update positions of other songs
        if ($newPosition < $oldPosition) {
            // Moving up: increment positions between new and old
            self::where('playlist_id', $playlistId)
                ->where('position', '>=', $newPosition)
                ->where('position', '<', $oldPosition)
                ->increment('position');
        } else {
            // Moving down: decrement positions between old and new
            self::where('playlist_id', $playlistId)
                ->where('position', '>', $oldPosition)
                ->where('position', '<=', $newPosition)
                ->decrement('position');
        }

        // Update this song's position
        $this->update(['position' => $newPosition]);
    }

    /**
     * Check if song already exists in playlist.
     */
    public static function existsInPlaylist(int $playlistId, int $songId): bool
    {
        return self::where('playlist_id', $playlistId)
                   ->where('song_id', $songId)
                   ->exists();
    }

    /**
     * Get songs in playlist order.
     */
    public static function getPlaylistSongs(int $playlistId)
    {
        return self::with(['song.album.artist'])
                   ->where('playlist_id', $playlistId)
                   ->ordered()
                   ->get()
                   ->pluck('song');
    }
}