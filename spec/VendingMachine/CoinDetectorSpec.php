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

    function it_detects_nicles(Coin $coin)
    {
        $coin->getWeight()->willReturn(2);
        $this->getValue($coin)->shouldBe(5);
    }

}
