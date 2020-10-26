<?php

namespace VendingMachine;

class VendingMachine
{
    private int $valueInserted = 0;
    /**
     * @var CoinDetectorInterface
     */
    private CoinDetectorInterface $coinDetector;
    private int $paymentRequired;

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

    public function selectProduct($product) : void
    {
        if ($product === 'cola') {
            $this->paymentRequired = 100;
        } elseif ($product === 'chips') {
            $this->paymentRequired = 50;
        } elseif ($product === 'candy') {
            $this->paymentRequired = 65;
        }
    }

    public function getPaymentRequired() : int
    {
        return $this->paymentRequired;
    }
}
