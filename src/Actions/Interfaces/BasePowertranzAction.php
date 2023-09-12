<?php
namespace Said\Powertranz\Actions\Interfaces;

use GuzzleHttp\Psr7\Response;
use Said\Powertranz\Requests\PowertranzClient;
use Said\Powertranz\Exceptions\BodyNotSetException;

abstract class BasePowertranzAction implements PowertranzAction
{
    public string $method = 'POST';
    private array $body;
    public function method(): string
    {
        return $this->method;
    }

    public static $instance;

    /*
     * Static function to return the singleton instance of this class
     * @return Said\Powertranz\Actions\Interfaces\BasePowertranzAction
     */
    public static function getInstance()
    {

        if (!isset(self::$instance)) {
            $instance = new static();
        }

        return $instance;
    }

    protected function parseBody(Response $request)
    {
        $bodyContent = $request->getBody()->getContents();
        if ($request->getStatusCode() === 200) {
            if ($request->hasHeader('Content-Type')) {
                if (str_contains($request->getHeader('Content-Type')[0], 'application/json')) {
                    return json_decode($bodyContent, true);
                }
            }
        }

        return $bodyContent;
    }

    public function submit()
    {
        if (!isset($this->body)) {
            throw new BodyNotSetException('Body not set');
        }

        $client   = PowertranzClient::getInstance()->client();
        $response = $client->request($this->method(), $this->url(), [
            'json' => $this->body,
        ]);

        return [
            'code' => $response->getStatusCode(),
            'body' => $this->parseBody($response),
        ];
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}
