<?php

namespace VendingMachine;

class CoinDetector implements CoinDetectorInterface
{
    const NICKLE_WEIGHT = 2;
    const DIME_WEIGHT = 3;
    const QUARTER_WEIGHT = 4;

    public function getValue(Coin $coin): int
    {
        if (!$this->isValidCoin($coin)) {
            return 0;
        }

        if ($coin->getWeight() === self::NICKLE_WEIGHT) {
            return 5;
        } elseif ($coin->getWeight() === self::DIME_WEIGHT) {
            return 10;
        } elseif ($coin->getWeight() === self::QUARTER_WEIGHT) {
            return 25;
        }
    }

    private function isValidCoin(Coin $coin) : bool
    {
        $validWeights = [self::NICKLE_WEIGHT, self::DIME_WEIGHT, self::QUARTER_WEIGHT];
        return in_array($coin->getWeight(), $validWeights);
    }
}
