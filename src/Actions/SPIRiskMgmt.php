<?php
namespace SchoolAid\Powertranz\Actions;

use SchoolAid\Powertranz\Actions\Interfaces\BasePowertranzAction;
use SchoolAid\Powertranz\Requests\PowertranzClient;

/*
 * Powertranz - /api/spi/riskmgmt
 * Type: Financtial
 * It's supposed to be non financtial,
 * it's used to preauthenticate a transaction, only works for 3DS.
 */
class SPIRiskMgmt extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/spi/riskmgmt';
    }

    // public function submit()
    // {
    //     $client   = PowertranzClient::getInstance()->client();
    //     $response = $client->request($this->method(), $this->url(), [
    //         'json'    => $this->token,
    //         'headers' => [
    //             'Content-Type' => 'application/json-patch+json',
    //         ],
    //     ]);

    //     return [
    //         'code' => $response->getStatusCode(),
    //         'body' => $this->parseBody($response),
    //     ];
    // }
}
