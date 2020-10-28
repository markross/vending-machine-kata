<?php

namespace VendingMachine;

class VendingMachine implements PaymentRecord
{

    private int $valueInserted = 0;
    /**
     * @var CoinDetectorInterface
     */
    private CoinDetectorInterface $coinDetector;
    /**
     * @var int $paymentRequired = 0;
     */
    private int $paymentRequired = 0;
    /**
     * @var Inventory
     */
    private Inventory $inventory;
    /**
     * @var int
     */
    private int $change;
    /**
     * @var CoinStoreInterface
     */
    private CoinStoreInterface $coinStore;
    /**
     * @var DisplayInterface
     */
    private DisplayInterface $display;

    public function __construct(
        CoinDetectorInterface $coinCounter,
        Inventory $inventory,
        CoinStoreInterface $coinStore,
        DisplayInterface $display
    )
    {
        $this->coinDetector = $coinCounter;
        $this->inventory = $inventory;
        $this->coinStore = $coinStore;
        $this->display = $display;

        $this->initialiseInventory($inventory);
    }

    public function receiveCoin(Coin $coin) : void
    {
        $value = $this->coinDetector->getValue($coin);
        $this->valueInserted += $value;
        $this->display->update($this);

        if ($this->productCanBeDispensed()) {
            $this->dispenseProduct();
        }
    }

    public function getTotalPaid() : int
    {
        return $this->valueInserted;
    }

    public function selectProduct($product) : void
    {
        if ($this->inventory->checkStock($product) === 0) {
            $this->display->showOutOfStock();
        } else {
            $this->paymentRequired = $this->inventory->getPrice($product);
            if ($this->productCanBeDispensed()) {
                $this->dispenseProduct();
            }
        }
        $this->display->update($this);
    }

    public function getPaymentRequired() : int
    {
        return $this->paymentRequired;
    }

    public function returnCoins()
    {
        $this->valueInserted = 0;
        $this->paymentRequired = 0;
        $this->display->update($this);
    }

    public function returnChange() : int
    {   $changeReturned = $this->change;
        $this->change = 0;
        return $changeReturned;
    }

    private function dispenseProduct()
    {
        $this->change = $this->valueInserted - $this->paymentRequired;
        $this->returnChange();
        $this->valueInserted = 0;
        $this->paymentRequired = 0;
        $this->display->showDispensed();
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

    /**
     * @return bool
     */
    private function productCanBeDispensed(): bool
    {
        return $this->valueInserted > 0
            && $this->valueInserted >= $this->paymentRequired
            && $this->paymentRequired > 0;
    }


}
