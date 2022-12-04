<?php

namespace App\Validations;

use Illuminate\Validation\Rule;

class PostReportValidation extends Validation
{
    public function rules(): array
    {
        return [
            "case" => ["required", "string", "max:500"],
            "post_id" => ["required", Rule::exists("posts", "id")],
            "user_id" => ["required", Rule::exists("users", "id")],
        ];
    }
}
