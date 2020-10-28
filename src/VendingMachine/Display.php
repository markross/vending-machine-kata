<?php

namespace VendingMachine;


class Display implements DisplayInterface
{
    const INSERT_COIN_MSG = "INSERT COIN";
    const DISPENSED_MSG = 'THANK YOU';
    const OUT_OF_STOCK_MSG = 'OUT OF STOCK';
    const EXACT_CHANGE_MSG = 'EXACT CHANGE ONLY';

    private string $message = self::INSERT_COIN_MSG;
    private string $flash = '';
    /**
     * @var CoinStoreInterface
     */
    private CoinStoreInterface $coinStore;

    public function __construct(CoinStoreInterface $coinStore)
    {
        $this->coinStore = $coinStore;
        if (!$coinStore->hasChange()) {
            $this->message = self::EXACT_CHANGE_MSG;
        }
    }

    public function update(PaymentRecord $vendingMachine): void
    {
        if ($vendingMachine->getPaymentRequired() > 0) {
            $this->message = "PRICE " . $this->formatCurrency($vendingMachine->getPaymentRequired());
        }

        if ($vendingMachine->getTotalPaid() > 0
            && $vendingMachine->getTotalPaid() > $vendingMachine->getPaymentRequired())
        {
            $this->message =  $this->formatCurrency($vendingMachine->getTotalPaid());
        }
    }

    public function getMessage(): string
    {
        if ($this->flash !== '') {
            $message = $this->flash;
            $this->flash = '';
        } else {
            $message = $this->message;
        }

        return $message;
    }

    public function showDispensed()
    {
        $this->flash = self::DISPENSED_MSG;
    }

    public function showOutOfStock()
    {
        $this->flash = self::OUT_OF_STOCK_MSG;
    }

    /**
     * @param int $value
     * @return string
     */
    private function formatCurrency(int $value): string
    {
        return '$ ' . number_format($value / 100, 2);
    }

}
