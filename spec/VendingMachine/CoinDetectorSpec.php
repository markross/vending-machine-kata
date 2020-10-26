<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Coin;
use VendingMachine\CoinDetector;

class CoinDetectorSpec extends ObjectBehavior
{

    function it_rejects_pennies(Coin $coin)
    {
        $coin->getWeight()->willReturn(1);
        $this->getValue($coin)->shouldBe(0);
    }

    function it_detects_nickles(Coin $coin)
    {
        $coin->getWeight()->willReturn(CoinDetector::NICKLE_WEIGHT);
        $this->getValue($coin)->shouldBe(CoinDetector::NICKLE_VALUE);
    }

    function it_detects_dimes(Coin $coin)
    {
        $coin->getWeight()->willReturn(CoinDetector::DIME_WEIGHT);
        $this->getValue($coin)->shouldBe(CoinDetector::DIME_VALUE);
    }

    function it_detects_quarters(Coin $coin)
    {
        $coin->getWeight()->willReturn(CoinDetector::QUARTER_WEIGHT);
        $this->getValue($coin)->shouldBe(CoinDetector::QUARTER_VALUE);
    }

}
