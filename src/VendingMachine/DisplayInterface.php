<?php


namespace VendingMachine;


interface DisplayInterface
{
    public function update(VendingMachine $vendingMachine): void;
    public function getMessage(): string;
    public function showDispensed();
    public function showOutOfStock();
}