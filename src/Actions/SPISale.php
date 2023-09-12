<?php
namespace Said\Powertranz\Actions;

use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/spi/sale
 * Type: Financtial
 * Makes a SPI Authorization with capture.
 */
class SPISale extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/spi/sale';
    }
}
