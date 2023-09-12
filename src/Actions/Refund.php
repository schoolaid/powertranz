<?php
namespace SchoolAid\Powertranz\Actions;

use SchoolAid\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/refund
 * Type: Financtial
 * Refund an already authorized and captured transaction
 */
class Refund extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/refund';
    }
}
