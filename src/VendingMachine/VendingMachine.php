<?php

namespace VendingMachine;

class VendingMachine
{
    private int $valueInserted = 0;
    /**
     * @var CoinDetectorInterface
     */
    private CoinDetectorInterface $coinDetector;
    /**
     * @var int $paymentRequired
     */
    private int $paymentRequired = 0;
    /**
     * @var Inventory
     */
    private Inventory $inventory;

    public function __construct(CoinDetectorInterface $coinCounter, Inventory $inventory)
    {
        $this->coinDetector = $coinCounter;
        $this->inventory = $inventory;

        $this->initialiseInventory($inventory);
    }

    public function receiveCoin(Coin $coin) : bool
    {
        $value = $this->coinDetector->getValue($coin);
        $this->valueInserted += $value;

        return true;
    }

    public function getTotalPaid() : int
    {
        return $this->valueInserted;
    }

    public function getMessage()
    {
        if ($this->valueInserted === 0) {
            return "INSERT COIN";
        } else {
            return '$ 0.25';
        }
    }

    public function selectProduct($product) : void
    {
        $this->paymentRequired = $this->inventory->getPrice($product);
    }

    public function getPaymentRequired() : int
    {
        return $this->paymentRequired;
    }

    /**
     * @param Inventory $inventory
     */
    private function initialiseInventory(Inventory $inventory): void
    {
        $products =
            [
                [
                    "sku" => 'cola',
                    "price" => 100,
                ],
                [
                    "sku" => 'chips',
                    "price" => 50,
                ],
                [
                    "sku" => 'candy',
                    "price" => 65
                ]
            ];

        array_map(
            function ($product) use ($inventory) {
                $inventory->addProduct($product);
            },
            $products
        );
    }
}
