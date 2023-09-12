<?php
namespace SchoolAid\Powertranz\Actions;

use SchoolAid\Powertranz\Requests\PowertranzClient;
use SchoolAid\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/spi/payment
 * Type: Financtial
 * Ends a payment for a preauthorized 3DS payment or an authorization request.
 */
class SPIPayment extends BasePowertranzAction
{
    private string $token;
    public function url(): string
    {
        return 'api/spi/payment';
    }

    public function submit()
    {
        $client   = PowertranzClient::getInstance()->client();
        $response = $client->request($this->method(), $this->url(), [
            'json'    => $this->token,
            'headers' => [
                'Content-Type' => 'application/json-patch+json',
            ],
        ]);

        return [
            'code' => $response->getStatusCode(),
            'body' => $this->parseBody($response),
        ];
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}
