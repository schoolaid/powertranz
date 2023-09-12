<?php
namespace Said\Powertranz\Requests;

use GuzzleHttp\Client;
use Said\Powertranz\Requests\Headers;
use Illuminate\Support\Facades\Config;

class PowertranzClient
{
    /*
     * @var Said\Powertranz\Request\PowertranzClient $instace Variable for singleton instance
     */
    public static PowertranzClient $instance;

    /*
     * @var GuzzleHttp\Client $client Guzzle client for connection to Powertranz
     */
    private Client $client;

    /*
     * Static function to return the singleton instance of this class
     * @return Said\Powetranz\Request\PowertranzClient
     */
    public static function getInstance(): PowertranzClient
    {

        if (!isset(self::$instance)) {
            $instance = new static();
        }

        return $instance;
    }

    public function __construct()
    {
        $powertranzURL = config('powertranz.url');
        $this->client  = new Client([
            'base_uri' => $powertranzURL,
            'headers'  => Headers::build(),
        ]);
    }

    public function client()
    {
        return $this->client;
    }
}
