<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Actions\SPIRiskMgmt;
use Said\Powertranz\Exceptions\NotImplementedException;

class SPIRiskMgmtActionTest extends UnitTestCase
{
    public function testRisKMgmtNotImplemented()
    {
        $this->expectException(NotImplementedException::class);
        $response = SPIRiskMgmt::getInstance()->submit();
    }
}
