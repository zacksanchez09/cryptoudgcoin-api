<?php

namespace App\RateService;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Services\WalletService;
use Illuminate\Support\Arr;

class RateService extends \Bavix\Wallet\Simple\Rate
{
    // list of exchange rates (take from the database)
    protected $rates = [
        'MXN' => [
            'UDGC' => 10.0,
        ],
        'UDGC' => [
            'MXN' => 1.0,
        ],
    ];

    protected function rate(Wallet $wallet): float
    {
        $from = app(WalletService::class)->getWallet($this->withCurrency);
        $to = app(WalletService::class)->getWallet($wallet);

        return Arr::get(
            Arr::get($this->rates, $from->currency, []),
            $to->currency,
            1
        );
    }

    public function convertTo(Wallet $wallet): float
    {
        return parent::convertTo($wallet) * $this->rate($wallet);
    }
}
