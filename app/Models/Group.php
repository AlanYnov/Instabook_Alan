<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Photo};

/**
 * Le modèle Group qui est lié à la table groups dans la base de données
 * 
 * @author Alan Philipiert <alan.philipiert@ynov.com>
 * 
 */
class Group extends Model
{
    use HasFactory;

    /**
     * Renvoie la liste des photos associés au groupe
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Renvoie tous les utilisateurs qui sont assignés au groupe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)            
            ->using("App\Models\GroupUser")
            ->withPivot("id")
            ->withTimestamps();
    }
}
