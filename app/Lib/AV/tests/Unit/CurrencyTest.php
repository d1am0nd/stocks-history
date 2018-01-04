<?php

namespace Tests\Unit;

use Tests\Unit\ParentTest;

class CurrencyTest extends ApiParent
{
    public function testCurrencyExchangeRate()
    {
        $exp = [
            'from' => 'USD',
            'to' => 'EUR',
        ];
        $res = $this->digitalCurrency->currencyExchangeRate($exp['from'], $exp['to']);
        // Assert correct function
        $this->paramEquals($res, 'function', 'CURRENCY_EXCHANGE_RATE');
        // Assert correct parameters
        $this->paramsEqual($res, $exp);
    }
}
