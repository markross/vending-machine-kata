<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Coin;
use VendingMachine\CoinDetector;
use VendingMachine\CoinDetectorInterface;

class VendingMachineSpec extends ObjectBehavior
{
    const INSERT_COIN_MSG = "INSERT COIN";

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
        $coinDetector->getValue($coin)->willReturn(CoinDetector::NICKLE_VALUE);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(CoinDetector::NICKLE_VALUE);
    }

    function it_detects_a_dime(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(CoinDetector::DIME_VALUE);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(CoinDetector::DIME_VALUE);
    }

    function it_detects_a_quarter(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(CoinDetector::QUARTER_VALUE);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(CoinDetector::QUARTER_VALUE);
    }

    function it_rejects_pennies(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(0);
        $this->receiveCoin($coin);
        $this->getTotalPaid()->shouldBe(0);
    }

    function it_receives_multiple_coins(Coin $coin1, Coin $coin2, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin1)->willReturn(CoinDetector::DIME_VALUE);
        $coinDetector->getValue($coin2)->willReturn(CoinDetector::QUARTER_VALUE);
        $this->receiveCoin($coin1);
        $this->receiveCoin($coin2);
        $this->getTotalPaid()->shouldBe(CoinDetector::DIME_VALUE + CoinDetector::QUARTER_VALUE);
    }

    function it_displays_insert_coin_message_when_no_coins_inserted()
    {
        $this->getMessage()->shouldBe(self::INSERT_COIN_MSG);
    }
}
