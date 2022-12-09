<?php

namespace App\Validations;

use Illuminate\Validation\Rule;

class PostReportValidation extends Validation
{
    public function rules(): array
    {
        return [
            "case" => ["required", "string", "max:500"],
        ];
    }
}
