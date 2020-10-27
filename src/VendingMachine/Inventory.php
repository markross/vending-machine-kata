<?php

namespace VendingMachine;

class Inventory
{

    private array $products = [];

    public function addProduct(array $productDetails)
    {
        $this->products[$productDetails["sku"]] =
            [
                "price" => $productDetails["price"],
                "stock" => $productDetails["stock"],
            ];
    }

    public function getPrice($sku)
    {
        return $this->products[$sku]["price"];
    }

    public function checkStock($sku)
    {
        return $this->products[$sku]["stock"];
    }

}
