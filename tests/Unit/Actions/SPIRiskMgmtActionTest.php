<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Actions\SPIRiskMgmt;
use SchoolAid\Powertranz\Exceptions\NotImplementedException;

class SPIRiskMgmtActionTest extends UnitTestCase
{
    public function testRisKMgmtNotImplemented()
    {
        $this->expectException(NotImplementedException::class);
        $response = SPIRiskMgmt::getInstance()->submit();
    }
}
