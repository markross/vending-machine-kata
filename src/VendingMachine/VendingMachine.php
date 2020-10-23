<?php

namespace VendingMachine;

class VendingMachine
{
    private int $valueInserted = 0;

    public function receiveCoin(Coin $coin) : bool
    {
        if ($coin->getWeight() === 2) {
            $this->valueInserted = 10;
        } else {
            $this->valueInserted = 5;
        }

        return true;
    }

    public function getTotalPaid() : int
    {
        return $this->valueInserted;
    }
}
