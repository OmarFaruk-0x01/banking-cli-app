<?php

namespace BankingApp\Model;

class Money
{
    public function __construct(
        private int $amount,
        private Currency $currency = Currency::BDT,
    )
    {
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }


    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function __toString(): string
    {
        return "{$this->amount} {$this->currency->name}";
    }
}