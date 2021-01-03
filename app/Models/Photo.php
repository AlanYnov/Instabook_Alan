<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Group, Comment, Tag, User};

/**
 * Le modèle Photo qui est lié à la table photos dans la base de données
 * 
 * @author Alan Philipiert <alan.philipiert@ynov.com>
 * 
 */
class Photo extends Model
{
    use HasFactory;

    /**
     * Renvoie la liste des commentaires associés à la photo
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * Renvoie le groupe de la photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Renvoie l'utilisateur propriétaire de la photo (celui qui l'a créé)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Renvoie tous les utilisateurs qui sont assignés à la photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class)            
        ->using("App\Models\PhotoUser")
        ->withPivot("id")
        ->withTimestamps();
    }

    /**
     * Renvoie tous les tags qui sont assignés à la photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)        
            ->using("App\Models\PhotoTag")
            ->withPivot("id")
            ->withTimestamps();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {   
        /**
         * On vérifie l'utilisateur appartienne bien au groupe auquel on essaye d'assigner la photo. 
         * 
         */
        //Si la fonction renvoi faux, la création ne se fait pas, sinon elle s'effectue
        static::creating(function ($photo) {
            return $photo->group->users->find($photo->user_id ) !== null; 
        });
    }
}
 