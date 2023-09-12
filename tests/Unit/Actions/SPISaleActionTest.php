<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Said\Powertranz\Actions\SPISale;
use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Requests\PowertranzBody;
use Said\Powertranz\Entities\PowertranzCreditCard;
use Said\Powertranz\Exceptions\BodyNotSetException;

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
