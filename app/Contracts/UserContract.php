<?php

namespace App\Contracts;

interface UserContract
{
    public function createUser(array $attibutes): mixed;
}
