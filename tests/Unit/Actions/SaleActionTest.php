<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Said\Powertranz\Actions\Sale;
use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Requests\PowertranzBody;
use Said\Powertranz\Entities\PowertranzCreditCard;
use Said\Powertranz\Exceptions\BodyNotSetException;

class SaleActionTest extends UnitTestCase
{
    public function testSaleNoBodySet()
    {
        $this->expectException(BodyNotSetException::class);
        Sale::getInstance()->submit();
    }

    public function testSale()
    {
        $cc       = new PowertranzCreditCard("1", "4012000000020071", "000", "2505", "Test");
        $body     = PowertranzBody::fromCreditCard($cc);
        $response = Sale::getInstance()->setBody($body)->submit();

        $this->assertEquals(200, $response['code']);
        $this->assertEquals(2, $response['body']['TransactionType']);
    }
}
