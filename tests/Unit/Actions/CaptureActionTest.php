<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Ramsey\Uuid\Uuid;
use Said\Powertranz\Actions\Capture;
use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Requests\PowertranzBody;
use Said\Powertranz\Exceptions\BodyNotSetException;

class CaptureActionTest extends UnitTestCase
{
    public function testCaptureNoBodySet()
    {
        $this->expectException(BodyNotSetException::class);
        Capture::getInstance()->submit();
    }

    public function testCaptureTransaction()
    {
        $invalidIdentifier = Uuid::uuid4();
        $body              = PowertranzBody::capturePowertranzBody($invalidIdentifier, 10, $invalidIdentifier);
        $response          = Capture::getInstance()->setBody($body)->submit();

        $this->assertEquals(200, $response['code']);
        $this->assertEquals(3, $response['body']['TransactionType']);
    }
}
