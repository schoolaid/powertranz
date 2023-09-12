<?php
namespace SchoolAid\Powertranz\Actions\Interfaces;

interface PowertranzAction
{
    public function url(): string;
    public function method(): string;
    public function submit();
}
