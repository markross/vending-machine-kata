<?php


namespace VendingMachine;


interface CoinDetectorInterface
{
    public function getValue(Coin $coin) : int;
}
