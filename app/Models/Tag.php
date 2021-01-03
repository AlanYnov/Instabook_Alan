<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

/**
 * Le modèle Tag qui est lié à la table tags dans la base de données
 * 
 * @author Alan Philipiert <alan.philipiert@ynov.com>
 * 
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * Renvoie tous les photos qui sont associées au tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class)                    
            ->using("App\Models\PhotoTag")
            ->withPivot("id")
            ->withTimestamps();
    }

}
