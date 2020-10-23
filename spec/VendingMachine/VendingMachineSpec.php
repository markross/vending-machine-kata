<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\VendingMachine;

class VendingMachineSpec extends ObjectBehavior
{
    function it_accepts_coins()
    {
        $this->receiveCoin()->shouldBe(true);
    }

}
