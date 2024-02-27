<?php
namespace SchoolAid\Powertranz\Requests;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use SchoolAid\Powertranz\Requests\Headers;

class PowertranzClient
{
    /*
     * @var SchoolAid\Powertranz\Request\PowertranzClient $instace Variable for singleton instance
     */
    public static PowertranzClient $instance;

    /*
     * @var GuzzleHttp\Client $client Guzzle client for connection to Powertranz
     */
    private Client $client;

    /*
     * Static function to return the singleton instance of this class
     * @return SchoolAid\Powetranz\Request\PowertranzClient
     */
    public static function getInstance(): PowertranzClient
    {

        if (!isset(self::$instance)) {
            $instance = new static();
        }

        return $instance;
    }

    public function __construct(Headers $customHeaders = null)
    {
        $powertranzURL = config('powertranz.url');
        $this->client  = new Client([
            'base_uri' => $powertranzURL,
            'headers'  => $customHeaders ?? Headers::build(),
        ]);
    }

    public function client()
    {
        return $this->client;
    }
}
