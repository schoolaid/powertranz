<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use SchoolAid\Powertranz\Actions\SPISale;
use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Entities\PowertranzCreditCard;
use SchoolAid\Powertranz\Exceptions\BodyNotSetException;

class SPISaleActionTest extends UnitTestCase
{
    public function testSPISaleNoBodySet()
    {
        $this->expectException(BodyNotSetException::class);
        SPISale::getInstance()->submit();
    }

    public function testSPISale()
    {
        $cc       = new PowertranzCreditCard("1", "4012000000020071", "000", "2505", "Test");
        $body     = PowertranzBody::fromCreditCard($cc);
        $response = SPISale::getInstance()->setBody($body)->submit();

        $this->assertEquals(200, $response['code']);
        $this->assertEquals(2, $response['body']['TransactionType']);
    }
}
