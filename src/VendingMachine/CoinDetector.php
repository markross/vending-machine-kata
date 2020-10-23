<?php

namespace VendingMachine;

class CoinDetector implements CoinDetectorInterface
{
    public function getValue(Coin $coin): int
    {
        return 0;
    }
}
