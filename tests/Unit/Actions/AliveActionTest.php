<?php
namespace Said\Powertranz\Tests\Unit\Actions;

use Said\Powertranz\Actions\Alive;
use Said\Powertranz\Tests\UnitTestCase;

class AliveActionTest extends UnitTestCase
{
    public function testAliveAction()
    {
        $response = Alive::getInstance()->submit();
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('PowerTranz Api', $response['body']['Name']);
        $this->assertTrue(true);
    }
}
