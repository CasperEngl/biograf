<?php

namespace App\Repositories;

use App\Seat;
use App\Repositories\RepositoryInterface;

class SeatRepository implements RepositoryInterface
{
  // model property on class instances
  protected $seat;

  // Constructor to bind model to repo
  public function __construct(Seat $seat)
  {
    $this->seat = $seat;
  }

  // Get all instances of model
  public function all()
  {
    return $this->seat->all();
  }

  // create a new record in the database
  public function create(array $data)
  {
    return $this->seat->create($data);
  }

  // update record in the database
  public function update($id, array $data)
  {
    $record = $this->find($id);

    return $record->update($data);
  }

  // remove record from the database
  public function delete($id)
  {
    return $this->seat->destroy($id);
  }

  // show the record with the given id
  public function show($id)
  {
    return $this->seat-findOrFail($id);
  }

  // Get the associated model
  public function getModel()
  {
    return $this->seat;
  }

  // Set the associated model
  public function setModel($seat)
  {
    $this->seat = $seat;

    return $this;
  }

  // Eager load database relationships
  public function with($relations)
  {
    return $this->seat->with($relations);
  }
}