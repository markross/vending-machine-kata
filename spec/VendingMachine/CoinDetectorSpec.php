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
        $this->detect($coin)->shouldBe(0);
    }

}
