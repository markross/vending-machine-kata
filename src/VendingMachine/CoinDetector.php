<?php

namespace VendingMachine;

class CoinDetector implements CoinDetectorInterface
{
    const NICKLE_WEIGHT = 2;

    public function getValue(Coin $coin): int
    {
        if ($coin->getWeight() === self::NICKLE_WEIGHT) {
            return 5;
        }

        return 0;
    }
}
