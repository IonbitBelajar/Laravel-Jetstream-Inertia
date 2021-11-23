<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


    public function viewAny(User $user)  // controller index()
    {
        if ($user->hasRole('user') ) {
            return true;
        }

    }

        /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Post $post)
    {
        if ($user->hasRole('user')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user) // controller create() , store()
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Post $post) // controller edit(), update()
    {
        if ($user->hasRole('user') && $user->id === $post->id) {
            return true;
        }


    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)// controller destroy()
    {
        if ($user->hasRole('user') && $user->id === $post->user_id) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user     
     * @param  \App\Models\Post  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Post $post, Post $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user          
     * @param  \App\Models\Post  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Post $post, Post $model)
    {
        //
    }
}
