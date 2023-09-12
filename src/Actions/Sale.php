<?php
namespace Said\Powertranz\Actions;

use Said\Powertranz\Actions\Interfaces\BasePowertranzAction;

class Sale extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/sale';
    }
}
