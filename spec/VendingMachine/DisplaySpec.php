<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Coin;
use VendingMachine\CoinStoreInterface;
use VendingMachine\Display;
use VendingMachine\StoreInterface;
use VendingMachine\VendingMachine;

class DisplaySpec extends ObjectBehavior
{
    function let(CoinStoreInterface $coinStore)
    {
        $this->beConstructedWith($coinStore);
        $coinStore->hasChange()->willReturn(true);
    }

    function it_displays_the_price(StoreInterface $store)
    {
        $store->getPaymentRequired()->willReturn(50);
        $store->getTotalPaid()->willReturn(0);
        $this->update($store);
        $this->getMessage()->shouldBe("PRICE $ 0.50");
    }

    function it_displays_the_amount_inserted(StoreInterface $store)
    {
        $store->getTotalPaid()->willReturn(25);
        $store->getPaymentRequired()->willReturn(0);
        $this->update($store);
        $this->getMessage()->shouldBe('$ 0.25');
    }

    function it_displays_out_of_stock_message()
    {
        $this->showOutOfStock();
        $this->getMessage()->shouldBe(Display::OUT_OF_STOCK_MSG);
    }

    function it_will_show_insert_coin_following_out_of_stock_message(StoreInterface $store, CoinStoreInterface $coinStore)
    {
        $this->showOutOfStock();
        $this->getMessage();
        $this->getMessage()->shouldBe(Display::INSERT_COIN_MSG);
    }

    function it_will_show_value_inserted_after_out_of_stock_message(StoreInterface $store)
    {
        $store->getTotalPaid()->willReturn(25);
        $store->getPaymentRequired()->willReturn(0);
        $this->update($store);
        $this->showOutOfStock();
        $this->getMessage()->shouldBe(Display::OUT_OF_STOCK_MSG);
        $this->getMessage()->shouldBe('$ 0.25');
    }

    function it_will_display_thank_you_message()
    {
        $this->showDispensed();
        $this->getMessage()->shouldBe(Display::DISPENSED_MSG);
    }

    function it_will_display_insert_coin_message_after_dispensing(StoreInterface $store)
    {
        $this->showDispensed();
        $store->getTotalPaid()->willReturn(0);
        $this->getMessage()->shouldBe(Display::DISPENSED_MSG);
        $this->getMessage()->shouldBe(Display::INSERT_COIN_MSG);
    }

    function it_will_display_exact_change_message_if_coin_store_out_of_change(CoinStoreInterface $coinStore)
    {
        $coinStore->hasChange()->willReturn(false);
        $this->getMessage()->shouldBe(Display::EXACT_CHANGE_MSG);
    }

}
