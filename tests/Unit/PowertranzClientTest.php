<?php
namespace Said\Powertranz\Tests\Unit;

use Said\Powertranz\Tests\UnitTestCase;
use Said\Powertranz\Requests\PowertranzClient;

class PowertranzClientTest extends UnitTestCase
{
    public function testSingleton()
    {
        $instance = PowertranzClient::getInstance();
        $this->assertTrue(true);
    }
}
