<?php
namespace Said\Powertranz\Actions;

use Said\Powertranz\Exceptions\NotImplementedException;
use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/spi/riskmgmt
 * Type: Financtial
 * It's supposed to be non financtial,
 * it's used to preauthenticate a transaction, only works for 3DS.
 */
class SPIRiskMgmt extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/spi/riskmgmt';
    }

    public function submit()
    {
        throw new NotImplementedException("Not implemented");
    }
}
