<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Coin;

class VendingMachineSpec extends ObjectBehavior
{
    function it_accepts_coins(Coin $coin)
    {
        $this->receiveCoin($coin)->shouldBe(true);
    }

    function it_detects_a_nickle(Coin $coin)
    {
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(5);
    }

    function it_detects_a_dime(Coin $coin)
    {
        $coin->getWeight()->willReturn(2);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(10);
    }

    function it_detects_a_quarter(Coin $coin)
    {
        $coin->getWeight()->willReturn(3);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(25);
    }

    function it_rejects_pennies(Coin $coin)
    {
        $coin->getWeight()->willReturn(1.5);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(0);
    }

}
