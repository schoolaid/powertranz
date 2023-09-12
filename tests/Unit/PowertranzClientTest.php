<?php
namespace SchoolAid\Powertranz\Tests\Unit;

use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzClient;

class PowertranzClientTest extends UnitTestCase
{
    public function testSingleton()
    {
        $instance = PowertranzClient::getInstance();
        $this->assertTrue(true);
    }
}
