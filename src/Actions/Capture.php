<?php
namespace Said\Powertranz\Actions;

use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

/*
 * Powertranz - /api/capture
 * Type: Financtial
 * Captures an authorized payment request
 */
class Capture extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/capture';
    }
}
