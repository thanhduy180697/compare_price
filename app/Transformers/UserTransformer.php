<?php

namespace App\Transformers;
use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            //
            'identifier' => (int)$user->id,
            'nameUser' => (string)$user->name,
            'emailUser' => (string)$user->email,
            'isVerified' => (int)$user->verified,
            'isAdmin' => ($user->admin === 'true'),
            'creationDate' => (string)$user->created_at,
            'lastChange' => (string)$user->update_at,
            'deleteDate' => isset($user->delele_at) ? (string) $user->deleted_at : null,
            'links' => 
            [
                'rel' => 'self',
                'href' => route('users.show', $user->id),
            ],
        ];
    }
    public static function originalAttribute($index){
        $attributes = [
            //
            'identifier' => 'id',
            'nameUser' => 'name',
            'emailUser' => 'email',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
            'isVerified' =>'verified',
            'isAdmin' => 'admin',
            'creationDate' => 'created_at',
            'lastChange' => 'update_at',
            'deleteDate' => 'delele_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null ;
    }
    public static function transformedlAttribute($index){
        $attributes = [
            //
            'id' => 'identifier',
            'name_user' => 'nameUser',
            'email' => 'emailUser',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
            'verified' =>'isVerified',
            'admin' => 'isAdmin',
            'created_at' => 'creationDate',
            'update_at' => 'lastChange',
            'delele_at' => 'deleteDate',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null ;
    } 
}