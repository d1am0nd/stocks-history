<?php

namespace Tests\Unit;

use Tests\Unit\ParentTest;
use AlphaVantage\Exception\BadDataTypeException;
use AlphaVantage\Exception\BadMethodCallException;

class MasterTest extends ApiParent
{
    public function testQuerySuccess()
    {
        $funcName = 'Some function';
        $additionalParams = [
            'test' => 'test',
            'test2' => 'test2',
        ];
        $this->master->setFuncAvailable(true);

        $res = $this->master->query($funcName, $additionalParams);
        // Assert correct function
        $this->paramEquals($res, 'function', $funcName);
        // Assert other params were passed
        $this->paramsEqual($res, $additionalParams);
    }

    public function testQueryBadMethodCallException()
    {
        $this->master->setFuncAvailable(false);

        $this->expectException(BadMethodCallException::class);
        $this->master->query('test', []);
    }

    public function testQueryBadDataTypeException()
    {
        $this->expectException(BadDataTypeException::class);
        $this->master->query('test', ['datatype' => 'csv']);
    }
}
