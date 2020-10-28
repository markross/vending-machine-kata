<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use VendingMachine\Coin;
use VendingMachine\CoinDetector;
use VendingMachine\CoinDetectorInterface;
use VendingMachine\Inventory;
use VendingMachine\VendingMachine;

class VendingMachineSpec extends ObjectBehavior
{
    const INSERT_COIN_MSG = "INSERT COIN";

    function let(CoinDetectorInterface $coinDetector, Inventory $inventory) {
        $this->beConstructedWith($coinDetector, $inventory);
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

    function it_sets_the_payment_required_when_selecting_a_product(Inventory $inventory)
    {
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->getPrice('cola')->willReturn(100);
        $inventory->checkStock('cola')->shouldBeCalled();
        $this->selectProduct('cola');
        $this->getPaymentRequired()->shouldBe(100);
    }

    function it_can_select_the_chips_product(Inventory $inventory)
    {
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->checkStock('chips')->shouldBeCalled();
        $inventory->getPrice('chips')->willReturn(50);
        $this->selectProduct('chips');
        $this->getPaymentRequired()->shouldBe(50);
    }

    function it_can_select_the_candy_product(Inventory $inventory)
    {
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->checkStock('candy')->shouldBeCalled();
        $inventory->getPrice('candy')->willReturn(65);
        $this->selectProduct('candy');
        $this->getPaymentRequired()->shouldBe(65);
    }

    function it_displays_the_payment_required_for_selected_product(Inventory $inventory)
    {
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->checkStock('candy')->shouldBeCalled();
        $inventory->getPrice('candy')->willReturn(65);
        $this->selectProduct('candy');
        $this->getMessage()->shouldBe("PRICE $ 0.65");
    }

    function it_shows_the_current_amount_inserted(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(25);
        $this->receiveCoin($coin);
        $this->getMessage()->shouldBeLike('$ 0.25');
    }

    function it_shows_the_current_amount_when_multiple_coins_inserted(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(25);
        $this->receiveCoin($coin);
        $this->receiveCoin($coin);
        $this->getMessage()->shouldBeLike('$ 0.50');
    }

    function it_dispenses_the_product_when_the_right_money_is_inserted(
        Coin $coin, CoinDetectorInterface
        $coinDetector,
        Inventory $inventory
    )
    {
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->checkStock('cola')->shouldBeCalled();
        $coinDetector->getValue($coin)->willReturn(CoinDetector::QUARTER_VALUE);
        $inventory->getPrice('cola')->willReturn(50);
        $this->selectProduct('cola');
        $this->receiveCoin($coin);
        $this->receiveCoin($coin);
        $this->getMessage()->shouldBe('THANK YOU');
    }

    function it_resets_when_returning_coins(Coin $coin, CoinDetectorInterface $coinDetector)
    {
        $coinDetector->getValue($coin)->willReturn(25);
        $this->receiveCoin($coin);
        $this->receiveCoin($coin);
        $this->returnCoins();
        $this->getMessage()->shouldBe(VendingMachine::INSERT_COIN_MSG);
        $this->getTotalPaid()->shouldBe(0);
    }

    function it_displays_out_stock_message_if_product_out_of_stock(Coin $coin, CoinDetectorInterface $coinDetector, Inventory $inventory)
    {
        $coinDetector->getValue($coin)->willReturn(25);
        $inventory->checkStock('cola')->willReturn(0);
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->getPrice('cola')->willReturn(50);
        $this->receiveCoin($coin);
        $this->receiveCoin($coin);
        $this->selectProduct('cola');
        $this->getMessage()->shouldBe(VendingMachine::OUT_OF_STOCK_MSG);
        $this->getMessage()->shouldBe('$ 0.50');
    }

    function it_displays_insert_coin_message_after_selecting_out_of_stock_product(CoinDetectorInterface $coinDetector, Inventory $inventory)
    {
        $inventory->checkStock('cola')->willReturn(0);
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->getPrice('cola')->willReturn(50);
        $this->selectProduct('cola');
        $this->getMessage()->shouldBe(VendingMachine::OUT_OF_STOCK_MSG);
        $this->getMessage()->shouldBe(VendingMachine::INSERT_COIN_MSG);
    }

    function it_dispenses_the_correct_change(Coin $coin, CoinDetectorInterface $coinDetector, Inventory $inventory)
    {
        $coinDetector->getValue($coin)->willReturn(25);
        $inventory->checkStock('cola')->shouldBeCalled();
        $inventory->addProduct(Argument::any())->shouldBeCalled();
        $inventory->getPrice('cola')->willReturn(65);
        $this->receiveCoin($coin);
        $this->receiveCoin($coin);
        $this->receiveCoin($coin);
        $this->selectProduct('cola');
        $this->returnChange()->shouldBe(10);
    }

}
