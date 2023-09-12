<?php
namespace SchoolAid\Powertranz\Actions;

use SchoolAid\Powertranz\Actions\Interfaces\BasePowertranzAction;

class Sale extends BasePowertranzAction
{
    public function url(): string
    {
        return 'api/sale';
    }
}
