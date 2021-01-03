<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Photo, Comment};


/**
 * Le modèle Comment qui est lié à la table comments dans la base de données
 * 
 * @author Alan Philipiert <alan.philipiert@ynov.com>
 * 
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * Renvoie l'utilisateur du commentaire
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Renvoie la photo qui appartient au commentaire
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * Renvoie la réponse qui appartient au commentaire
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replyTo(){
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    /**
     * Renvoie la liste des réponses associés au commentaire
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(){
        return $this->hasMany(Comment::class);
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
        static::creating(function ($comment) {
            return $comment->photo->group->users->find($comment->user_id ) !== null; 
        });
    }
}
