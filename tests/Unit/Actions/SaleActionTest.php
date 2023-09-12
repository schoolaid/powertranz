<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use SchoolAid\Powertranz\Actions\Sale;
use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Entities\PowertranzCreditCard;
use SchoolAid\Powertranz\Exceptions\BodyNotSetException;

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
