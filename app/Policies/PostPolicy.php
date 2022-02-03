<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Post $post
     * @return Response|bool
     */
    public function update(User $user, Post $post)
    {
        return ($user->isAdmin || $user->id === $post->user_id)
                    ? Response::allow()
                    : Response::deny('Only the administrator or the post owner can update this post.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Post $post
     * @return Response|bool
     */
    public function delete(User $user, Post $post)
    {
        return ($user->isAdmin || $user->id === $post->user_id)
                    ? Response::allow()
                    : Response::deny('Only the administrator or the post owner can delete this post.');
    }
}
