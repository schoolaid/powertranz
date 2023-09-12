<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Ramsey\Uuid\Uuid;
use Said\Powertranz\Actions\Refund;
use Said\Powertranz\Actions\Capture;
use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Requests\PowertranzBody;
use Said\Powertranz\Exceptions\BodyNotSetException;

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
