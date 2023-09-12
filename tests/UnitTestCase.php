<?php
namespace Said\Powertranz\Tests;

use Orchestra\Testbench\TestCase;

class UnitTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $app->get('config');

        $config->set('powertranz.url', env('POWERTRANZ_URL'));
        $config->set('powertranz.id', env('POWERTRANZ_ID'));
        $config->set('powertranz.password', env('POWERTRANZ_PASSWORD'));
    }

}
