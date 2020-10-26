<?php

namespace VendingMachine;

class VendingMachine
{
    private int $valueInserted = 0;
    /**
     * @var CoinDetectorInterface
     */
    private CoinDetectorInterface $coinDetector;

    public function __construct(CoinDetectorInterface $coinCounter)
    {
        $this->coinDetector = $coinCounter;
    }

    public function receiveCoin(Coin $coin) : bool
    {
        $value = $this->coinDetector->getValue($coin);
        $this->valueInserted += $value;

        return true;
    }

    public function getTotalPaid() : int
    {
        return $this->valueInserted;
    }

    public function getMessage()
    {
        return "INSERT COIN";
    }
}
