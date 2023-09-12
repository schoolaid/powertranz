<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use Ramsey\Uuid\Uuid;
use SchoolAid\Powertranz\Actions\Refund;
use SchoolAid\Powertranz\Actions\Capture;
use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Exceptions\BodyNotSetException;

class RefundActionTest extends UnitTestCase
{
    public function testRefundNoBody()
    {
        $this->expectException(BodyNotSetException::class);
        Refund::getInstance()->submit();
    }

    public function testRefundTransaction()
    {
        $invalidIdentifier = Uuid::uuid4();
        $body              = PowertranzBody::refundPowertranzBody($invalidIdentifier, 10, $invalidIdentifier);
        $response          = Capture::getInstance()->setBody($body)->submit();

        $this->assertEquals(200, $response['code']);
        $this->assertEquals(3, $response['body']['TransactionType']);
    }
}
