<?php

namespace VendingMachine;

class CoinDetector implements CoinDetectorInterface
{
    const NICKLE_WEIGHT = 2;
    const DIME_WEIGHT = 3;

    public function getValue(Coin $coin): int
    {
        if ($coin->getWeight() === self::NICKLE_WEIGHT) {
            return 5;
        } elseif ($coin->getWeight() === self::DIME_WEIGHT) {
            return 10;
        }

        return 0;
    }
}
