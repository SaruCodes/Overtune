<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_USER   = 'user';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_ADMIN  = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Helpers de rol
    public function isAdmin(): bool   { return $this->role === self::ROLE_ADMIN; }
    public function isEditor(): bool  { return $this->role === self::ROLE_EDITOR; }

    // Relaciones
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function comments()
    {
        return $this->hasMany(ReviewComment::class);
    }

    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function favoriteAlbums()
    {
        return $this->belongsToMany(Album::class, 'favorite_albums');
    }

    public function favoriteArtists()
    {
        return $this->belongsToMany(Artist::class, 'favorite_artists');
    }

    public function lists()
    {
        return $this->hasMany(ListModel::class);
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'follows', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(self::class, 'follows', 'follower_id', 'followed_id');
    }
}
