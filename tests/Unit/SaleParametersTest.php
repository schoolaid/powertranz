<?php
namespace Said\Powertranz\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Said\Powertranz\SaleParameters;
use Said\Powertranz\CreditCardParameters;

class SaleParametersTest extends TestCase
{
    public function testTotalABS()
    {
        $total          = -20;
        $saleParameters = new SaleParameters('111111111', '111', $total,
            new CreditCardParameters(
                '11111', '1111', '1111', '1111'
            )
        );
        $this->assertEquals(20, $saleParameters->total);
    }
}
