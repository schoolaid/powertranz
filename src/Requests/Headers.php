<?php
namespace SchoolAid\Powertranz\Requests;

use SchoolAid\Powertranz\Requests\PowertranzHeaders;
use SchoolAid\Powertranz\Exceptions\EnvNotSetException;

class Headers
{
    public static function build(string $powertranzId = null, string $powertranzPassword = null, string $powertranzGatewayKey = null): array
    {
        $powertranzId         = $powertranzId ?? config('powertranz.id');
        $powertranzPassword   = $powertranzPassword ?? config('powertranz.password');
        $powertranzGatewayKey = $powertranzGatewayKey ?? config('powertranz.gateway_key');
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
