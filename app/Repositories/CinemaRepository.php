<?php

namespace App\Repositories;

use App\Seat;
use App\Cinema;
use App\Repositories\RepositoryInterface;

class CinemaRepository implements RepositoryInterface
{
  // model property on class instances
  protected $cinema;

  // Constructor to bind model to repo
  public function __construct(Cinema $cinema, Seat $seat)
  {
    $this->cinema = $cinema;
    $this->seat = $seat;
  }

  // Get all instances of model
  public function all()
  {
    return $this->cinema->all();
  }

  // create a new record in the database
  public function create($request)
  {
    $cinema = $this->cinema::create($request);

    foreach ($request->seats as $seat) {
      $cinema->seats()->save($this->seat($seat));
    }

    return $cinema;
  }

  // update record in the database
  public function update($id, $request)
  {
    $record = $this->find($id);

    return $record->update($request);
  }

  // remove record from the database
  public function delete($id)
  {
    return $this->cinema->destroy($id);
  }

  // show the record with the given id
  public function show($id)
  {
    return $this->cinema-findOrFail($id);
  }

  // Get the associated model
  public function getModel()
  {
    return $this->cinema;
  }

  // Set the associated model
  public function setModel($cinema)
  {
    $this->cinema = $cinema;

    return $this;
  }

  // Eager load database relationships
  public function with($relations)
  {
    return $this->cinema->with($relations);
  }
}