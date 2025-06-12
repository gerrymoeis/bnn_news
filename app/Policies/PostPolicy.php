<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can manage posts (approve/reject).
     */
    public function manage(User $user): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Editor';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Wartawan';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // Only Admin or the post's author can update.
        return $user->role->name === 'Admin' || $user->id === $post->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // Only Admin or the post's author can delete.
        return $user->role->name === 'Admin' || $user->id === $post->author_id;
    }
}
