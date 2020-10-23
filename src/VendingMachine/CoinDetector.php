<?php

namespace VendingMachine;

class CoinDetector implements CoinDetectorInterface
{
    public function detect(Coin $coin): int
    {
        return 0;
    }
}
