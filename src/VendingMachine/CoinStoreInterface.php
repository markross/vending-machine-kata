<?php


namespace VendingMachine;


interface CoinStoreInterface
{
    public function hasChange() : bool;
    public function returnCoins(int $value): void;
}