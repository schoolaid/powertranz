<?php
namespace Said\Powertranz\Actions;

use GuzzleHttp\Psr7\Request;
use Said\Powertranz\Requests\PowertranzClient;
use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/alive
 * Type: No financtial
 * Returns api status
 */
class Alive extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/alive';
    }

    public function method(): string
    {
        return 'GET';
    }

    public function submit()
    {
        $client   = PowertranzClient::getInstance()->client();
        $response = $client->request($this->method(), $this->url());

        return [
            'code' => $response->getStatusCode(),
            'body' => $this->parseBody($response),
        ];
    }
}
