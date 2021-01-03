<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PhotoUser extends Pivot
{
    use HasFactory;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @see https://laravel.com/docs/8.x/eloquent-relationships#defining-custom-intermediate-table-models
     * @var bool
     */
    public $incrementing = true;

    /**
     * Renvoi la photo liée à l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Renvoi l'utilisateur' lié à la photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        /**
     * function that boot at model creation
     */
    protected static function booted()
    {
        /**
         * Verify the user belongs to the chosen groups before being able to comment
         *
         * @param Illuminate\Database\Eloquent\Model;
         * @return boolean;
         */
        static::creating(function($photoUser){
            $photo = Photo::where('id', $photoUser->photo_id)->first();
            $group_user = GroupUser::where('user_id', $photoUser->user_id)
                ->where('group_id', $photo->group->id);
            if(!$group_user->exists()) return false;
            return true;
        });
    }
}
