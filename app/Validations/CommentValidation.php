<?php

namespace App\Validations;

class CommentValidation extends Validation
{
    public function rules(): array
    {
        return [
            "body" => ["required", "string", "max:255"],
        ];
    }
}
