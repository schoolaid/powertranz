<?php
namespace Said\Powertranz\Requests;

enum PowertranzHeaders: string {
    case POWERTRANZ_ID          = 'PowerTranz-PowerTranzId';
    case POWERTRANZ_PASSWORD    = 'PowerTranz-PowerTranzPassword';
    case POWERTRANZ_GATEWAY_KEY = 'PowerTranz-GatewayKey';
}
