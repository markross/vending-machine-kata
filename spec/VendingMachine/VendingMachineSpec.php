<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Coin;

class VendingMachineSpec extends ObjectBehavior
{
    function it_accepts_coins()
    {
        $this->receiveCoin()->shouldBe(true);
    }

    function it_detects_a_nickle(Coin $coin)
    {
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(5);
    }


}
