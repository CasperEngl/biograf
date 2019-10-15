<?php

namespace App\Payment\Traits;

use App\Payment\Models\Transaction;

trait HasPayable
{
    /**
     * Get all of the model's transactions.
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'payable');
    }
}
