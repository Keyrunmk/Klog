<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class Validation
{
    protected $ignore = [];

    protected $messages = [];

    abstract public function rules(): array;

    public function ignore(...$ignore): Validation
    {
        $this->ignore = $ignore;

        return $this;
    }

    public function messages(...$messages): Validation
    {
        $this->messages = $messages;

        return $this;
    }

    public function run($input): array
    {
        if ($input instanceof Request) {
            $input =  $input->all();
        }

        if (! is_array($input)) {
            $input = (array) $input;
        }

        if (method_exists($this, "before")) {
            $this->before($input);
        }

        return Validator::make($input, $this->rules())->validate();

        if (method_exists($this, "after")) {
            $this->after($input);
        }
    }
}