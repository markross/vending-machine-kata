<?php


namespace VendingMachine;


interface StoreInterface
{
    public function getPaymentRequired(): int;
    public function getTotalPaid(): int;
}