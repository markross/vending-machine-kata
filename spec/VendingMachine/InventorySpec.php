<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Inventory;

class InventorySpec extends ObjectBehavior
{
    function it_can_add_products()
    {
        $this->addProduct([
           "sku"    => 'cola',
           "price"  => 100,
        ]);
    }

    function it_can_get_the_price_of_a_sku()
    {
        $this->addProduct([
            "sku"    => 'cola',
            "price"  => 100,
        ]);

        $this->getPrice('cola')->shouldBe(100);
    }
}
