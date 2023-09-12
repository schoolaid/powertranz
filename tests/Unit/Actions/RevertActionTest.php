<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Ramsey\Uuid\Uuid;
use Said\Powertranz\Actions\Revert;
use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Requests\PowertranzBody;
use Said\Powertranz\Entities\PowertranzCreditCard;
use Said\Powertranz\Exceptions\BodyNotSetException;

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
