<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Coin;
use VendingMachine\CoinDetectorInterface;

class VendingMachineSpec extends ObjectBehavior
{
    function let(CoinDetectorInterface $coinDetector) {
        $this->beConstructedWith($coinDetector);
    }

    function it_accepts_coins(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->shouldBeCalled();
        $this->receiveCoin($coin)->shouldBe(true);
    }

    function it_detects_a_nickle(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(5);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(5);
    }

    function it_detects_a_dime(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(10);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(10);
    }

    function it_detects_a_quarter(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(25);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(25);
    }

    function it_rejects_pennies(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(0);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(0);
    }

    function it_receives_multiple_coins(Coin $coin1, Coin $coin2, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin1)->willReturn(10);
        $coinDetector->getValue($coin2)->willReturn(25);
        $this->receiveCoin($coin1);
        $this->receiveCoin($coin2);
        $this->getTotalPaid()->shouldBe(35);
    }

}
