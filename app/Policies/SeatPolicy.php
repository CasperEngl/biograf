<?php

namespace App\Policies;

use App\Seat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reservations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return in_array(auth()->user()->email, [
            'me@casperengelmann.com',
            'casper@devant.dk',
            'test1@biograf.test',
            'test2@biograf.test',
        ]);
    }

    /**
     * Determine whether the user can view the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Seat  $seat
     * @return mixed
     */
    public function view(?User $user, Seat $seat)
    {
        return true;
    }

    /**
     * Determine whether the user can create reservations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // return $this->viewAny($user);
        return false;
    }

    /**
     * Determine whether the user can update the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Seat  $seat
     * @return mixed
     */
    public function update(?User $user, Seat $seat)
    {
        // return $seat->reserver_id == $user->id ?? session()->getId() || $this->viewAny($user);
        // return $this->viewAny($user);
        return false;
    }

    /**
     * Determine whether the user can delete the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Seat  $seat
     * @return mixed
     */
    public function delete(?User $user, Seat $seat)
    {
        // return $seat->reserver_id == $user->id ?? session()->getId() || $this->viewAny($user);
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can restore the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Seat  $seat
     * @return mixed
     */
    public function restore(?User $user, Seat $seat)
    {
        // return $seat->reserver_id == $user->id ?? session()->getId() || $this->viewAny($user);
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can permanently delete the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Seat  $seat
     * @return mixed
     */
    public function forceDelete(User $user, Seat $seat)
    {
        // return $this->viewAny($user);
        return false;
    }
}
