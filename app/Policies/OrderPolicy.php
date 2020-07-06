<?php

namespace App\Policies;
use App\Models\{ User, Order };
use Illuminate\Auth\Access\HandlesAuthorization;
class OrderPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function manage(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}