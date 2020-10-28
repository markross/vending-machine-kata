<?php

namespace VendingMachine;

class VendingMachine
{
    const INSERT_COIN_MSG = "INSERT COIN";
    const DISPENSED_MSG = 'THANK YOU';
    const OUT_OF_STOCK_MSG = 'OUT OF STOCK';

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

    private string $message = '';
    private int $change;

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

        if ($this->productCanBeDispensed()) {
            $this->dispenseProduct();
        }

        return true;
    }

    public function getTotalPaid() : int
    {
        return $this->valueInserted;
    }

    public function getMessage()
    {
        $message = self::INSERT_COIN_MSG;

        if ($this->paymentRequired > 0) {
            $message = "PRICE " . $this->formatCurrency($this->paymentRequired);
        }

        if ($this->valueInserted > 0 && $this->valueInserted > $this->paymentRequired) {
            $message =  $this->formatCurrency($this->valueInserted);
        }

        if ($this->message !== '') {
            $message = $this->message;
            $this->message = '';
        }

        return $message;
    }

    public function selectProduct($product) : void
    {
        if ($this->inventory->checkStock($product) === 0) {
            $this->message = self::OUT_OF_STOCK_MSG;
        } else {
            $this->paymentRequired = $this->inventory->getPrice($product);
            if ($this->productCanBeDispensed()) {
                $this->dispenseProduct();
            }
        }
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

    public function returnCoins()
    {
        $this->valueInserted = 0;
        $this->paymentRequired = 0;
    }

    public function returnChange() : int
    {   $changeReturned = $this->change;
        $this->change = 0;
        return $changeReturned;
    }

    /**
     * @param int $value
     * @return string
     */
    private function formatCurrency(int $value): string
    {
        return '$ ' . number_format($value / 100, 2);
    }

    private function dispenseProduct()
    {
        $this->message = self::DISPENSED_MSG;
        $this->change = $this->valueInserted - $this->paymentRequired;
        $this->valueInserted = 0;
        $this->paymentRequired = 0;
    }

    /**
     * @return bool
     */
    private function productCanBeDispensed(): bool
    {
        return $this->valueInserted > 0 && $this->valueInserted >= $this->paymentRequired && $this->paymentRequired > 0;
    }


}
