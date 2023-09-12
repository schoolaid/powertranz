<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use Ramsey\Uuid\Uuid;
use SchoolAid\Powertranz\Actions\Revert;
use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Entities\PowertranzCreditCard;
use SchoolAid\Powertranz\Exceptions\BodyNotSetException;

class RevertActionTest extends UnitTestCase
{
    public function testRevertNoBodySet()
    {
        $this->expectException(BodyNotSetException::class);
        Revert::getInstance()->submit();
    }

    public function testVoidTransaction()
    {
        $cc = new PowertranzCreditCard("1", "4012000000020006", "000", "2505", "Test");

        $invalidIdentifier = Uuid::uuid4();
        $revertBody        = PowertranzBody::fromCreditCard($cc, $invalidIdentifier, true);
        $revertResponse    = Revert::getInstance()->setBody($revertBody)->submit();

        $this->assertEquals(200, $revertResponse['code']);
        $this->assertEquals(4, $revertResponse['body']['TransactionType']);
    }
}
