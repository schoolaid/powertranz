<?php
namespace Said\Powertranz\Actions;

use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/spi/auth
 * Type: Financtial
 * Makes a SPI Authorization to reserve funds to capture after this.
 */
class SPIAuth extends BasePowertranzAction
{
    public function url(): string
    {
        return '/api/spi/auth';
    }
}
