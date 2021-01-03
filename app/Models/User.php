<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Group, Comment, Photo};

/**
 * Le modèle User qui est lié à la table users dans la base de données
 * 
 * @author Alan Philipiert <alan.philipiert@ynov.com>
 * 
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Renvoie la liste des commentaires associés à l'utilisateur
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Renvoie la liste des photos associés à l'utilisateur
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Renvoie tous les utilisateurs qui sont dans le groupe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)
            ->using("App\Models\GroupUser")
            ->withPivot("id")
            ->withTimestamps();
    }

    /**
     * Renvoie tous les photos qui appartiennent à l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function photosAppearance(){
        return $this->belongsToMany(Photo::class)
            ->using("App\Models\PhotoUser")
            ->withPivot("id")
            ->withTimestamps();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
