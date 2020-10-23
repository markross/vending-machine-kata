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
        $coin->getWeight()->willReturn(2);
        $this->getValue($coin)->shouldBe(5);
    }

    function it_detects_dimes(Coin $coin)
    {
        $coin->getWeight()->willReturn(3);
        $this->getValue($coin)->shouldBe(10);
    }

    function it_detects_quarters(Coin $coin)
    {
        $coin->getWeight()->willReturn(4);
        $this->getValue($coin)->shouldBe(25);
    }

}
