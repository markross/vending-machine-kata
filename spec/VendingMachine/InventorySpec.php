<?php

namespace spec\VendingMachine;

use PhpSpec\ObjectBehavior;
use VendingMachine\Inventory;

class InventorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Inventory::class);
    }
}
