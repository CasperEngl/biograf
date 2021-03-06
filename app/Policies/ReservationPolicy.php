<?php

namespace App\Policies;

use App\User;
use App\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
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
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function view(?User $user, Reservation $reservation)
    {
        return $reservation->reserver_id == (optional($user)->id ?? session()->getId()) || $this->viewAny($user);
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
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function update(?User $user, Reservation $reservation)
    {
        // return $reservation->reserver_id == $user->id ?? session()->getId() || $this->viewAny($user);
        return $reservation->reserver_id == (optional($user)->id ?? session()->getId());
    }

    /**
     * Determine whether the user can delete the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function delete(?User $user, Reservation $reservation)
    {
        // return $reservation->reserver_id == $user->id ?? session()->getId() || $this->viewAny($user);
        return $reservation->reserver_id == (optional($user)->id ?? session()->getId());
    }

    /**
     * Determine whether the user can restore the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function restore(?User $user, Reservation $reservation)
    {
        return $reservation->reserver_id == (optional($user)->id ?? session()->getId()) || $this->viewAny($user);
    }

    /**
     * Determine whether the user can permanently delete the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function forceDelete(User $user, Reservation $reservation)
    {
        // return $this->viewAny($user);
        return false;
    }
}
