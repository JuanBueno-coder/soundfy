<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;
use App\Models\Song;

class Album extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'release_date',
        'genre',
        'cover_image',
        'description'
    ];
    public function artist(){
        return $this->belongsTo(artist::class);
    }
    public function songs() {
    return $this->hasMany(Song::class);
}
}
