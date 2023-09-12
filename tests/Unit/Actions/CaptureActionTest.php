<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use Ramsey\Uuid\Uuid;
use SchoolAid\Powertranz\Actions\Capture;
use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Exceptions\BodyNotSetException;

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
