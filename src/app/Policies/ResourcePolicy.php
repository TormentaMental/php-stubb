<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    private $user;
    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function before()
    {
     
    }
    
     /**
     * Determine if the given resource is owned by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Model $resource
     * @return bool
     */
    public function ownership($resource)
    {
        return $this->user->id === $resource->user_id;
    }    
}
