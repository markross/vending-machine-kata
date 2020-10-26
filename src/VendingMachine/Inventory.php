<?php

namespace VendingMachine;

class Inventory
{

    private array $products = [];

    public function addProduct(array $productDetails)
    {
        $this->products[$productDetails["sku"]] = $productDetails["price"];
    }

    public function getPrice($sku)
    {
        return $this->products[$sku];
    }

}
