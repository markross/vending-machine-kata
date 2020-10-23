<?php

namespace VendingMachine;

class VendingMachine
{
    private int $valueInserted = 0;

    public function receiveCoin(Coin $coin) : bool
    {
        if ($coin->getWeight() === 1.5) {
            return false;
        }

        if ($coin->getWeight() === 2) {
            $this->valueInserted = $this->valueInserted + 10;
        } elseif ($coin->getWeight() === 3) {
            $this->valueInserted = $this->valueInserted + 25;
        } else {
            $this->valueInserted = $this->valueInserted + 5;
        }

        return true;
    }

    public function getTotalPaid() : int
    {
        return $this->valueInserted;
    }
}
