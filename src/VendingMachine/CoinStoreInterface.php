<?php


namespace VendingMachine;


interface CoinStoreInterface
{
    public function hasChange() : bool;
}