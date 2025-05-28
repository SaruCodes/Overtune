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

    public function isAdmin(): bool   { return $this->role === self::ROLE_ADMIN; }
    public function isEditor(): bool  { return $this->role === self::ROLE_EDITOR; }

    // Relaciones
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comment::class);
    }


    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function lists()
    {
        return $this->hasMany(ListModel::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    public function favoriteLists()
    {
        return $this->favorites()->where('favoritable_type', ListModel::class);
    }

    public function favoriteAlbums()
    {
        return $this->favorites()->where('favoritable_type', Album::class);
    }

    public function favoriteArtists()
    {
        return $this->favorites()->where('favoritable_type', Artist::class);
    }

}
