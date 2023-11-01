<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, ServiceOrder $order): bool
    {
        return $user->is($order->user) || $user->is($order->service->user);
    }
}
