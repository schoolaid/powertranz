<?php
namespace Said\Powertranz\Requests;

use Said\Powertranz\Requests\PowertranzHeaders;
use Said\Powertranz\Exceptions\EnvNotSetException;

class Headers
{
    public static function build(): array
    {
        $powertranzId         = config('powertranz.id');
        $powertranzPassword   = config('powertranz.password');
        $powertranzGatewayKey = config('powertranz.gateway_key');
        if (!$powertranzId) {
            throw new EnvNotSetException('POWERTRANZ_ID is not set.');
        }
        if (!$powertranzPassword) {
            throw new EnvNotSetException('POWERTRANZ_PASSWORD is not set.');
        }
        $headers = [
            PowertranzHeaders::POWERTRANZ_ID->value       => $powertranzId,
            PowertranzHeaders::POWERTRANZ_PASSWORD->value => $powertranzPassword,
        ];

        if ($powertranzGatewayKey) {
            $headers[PowertranzHeaders::POWERTRANZ_GATEWAY_KEY->value] = $powertranzGatewayKey;
        }

        return $headers;
    }
}
