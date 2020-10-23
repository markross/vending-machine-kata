<?php


namespace VendingMachine;


interface CoinDetectorInterface
{
    public function detect(Coin $coin) : int;
}
