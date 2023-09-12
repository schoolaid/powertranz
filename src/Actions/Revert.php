<?php
namespace Said\Powertranz\Actions;

use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/void
 * Type: Financtial
 * Used to rollback any authorization if the transaction have not been captured yet.
 */
class Revert extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/void';
    }
}
