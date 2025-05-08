<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function comments() {
        return $this->hasMany(ReviewComment::class);
    }

    public function news() {
        return $this->hasMany(News::class, 'author_id');
    }

    public function favoriteAlbums() {
        return $this->belongsToMany(Album::class, 'favorite_albums');
    }

    public function favoriteArtists() {
        return $this->belongsToMany(Artist::class, 'favorite_artists');
    }

    public function lists() {
        return $this->hasMany(ListModel::class);
    }

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

}
