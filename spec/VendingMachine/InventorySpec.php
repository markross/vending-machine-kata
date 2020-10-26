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
           "price"  => '100',
        ]);

    }
}
