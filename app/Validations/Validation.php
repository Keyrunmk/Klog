<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class Validation
{
    abstract public function rules(): array;

    public function validate(Request $input): array
    {
        $input =  $input->all();

        return Validator::make($input, $this->rules())->validate();
    }
}