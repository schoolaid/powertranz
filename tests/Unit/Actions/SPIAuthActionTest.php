<?php
namespace SchoolAid\Powertranz\Tests\Unit\Actions;

use SchoolAid\Powertranz\Actions\SPIAuth;
use SchoolAid\Powertranz\Actions\SPIPayment;
use SchoolAid\Powertranz\Tests\UnitTestCase;
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Entities\PowertranzCreditCard;
use SchoolAid\Powertranz\Exceptions\BodyNotSetException;

class SPIAuthActionTest extends UnitTestCase
{
    public function testSPIAuthNoBodySet()
    {
        $this->expectException(BodyNotSetException::class);
        SPIAuth::getInstance()->submit();
    }

    public function testSPIAuthVisa()
    {
        $cc       = new PowertranzCreditCard("1", "4012000000020071", "000", "2505", "Test");
        $body     = PowertranzBody::fromCreditCard($cc);
        $response = SPIAuth::getInstance()->setBody($body)->submit();

        $this->assertEquals(200, $response['code']);
        $this->assertEquals("SPI Preprocessing complete", $response['body']['ResponseMessage']);
        $this->assertEquals(1, $response['body']['TransactionType']);
        $this->assertFalse($response['body']['Approved']);

        $spiToken = $response['body']['SpiToken'];

        $paymentResponse = SPIPayment::getInstance()->setToken($spiToken)->submit();
        $this->assertEquals(200, $paymentResponse['code']);
    }
}
