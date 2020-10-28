<?php


namespace VendingMachine;


interface PaymentRecord
{
    public function getPaymentRequired(): int;
    public function getTotalPaid(): int;
}