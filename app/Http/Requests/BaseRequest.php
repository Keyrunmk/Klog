<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
{
    protected $redirectRoute = "user.error";

    public Model $model;
    public array $appendRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getRules()
    {
        $rules = [];
        $attributes = $this->model->getFillable();
        foreach ($attributes as $attribute) {
            $rules[$attribute] = $this->allRules()[$attribute];
        }

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return array_merge($this->getRules(), $this->appendRules);
    }

    public function allRules()
    {
        return [
            "first_name" => ["required", "string", "max:255"],
            "last_name" => ["required", "string", "max:255"],
            "username" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255", "unique:users,email"],
            "password" => ["required", "string", "min:8", "max:255"],
            "case" => ["required", "string", "max:255"],
            "title" => ["required", "max:255"],
            "slug" => ["required", Rule::unique("posts", "slug")->ignore($this->post)],
            "body" => ["required", "max:255"],
            "category_id" => ["required", Rule::exists("categories", "id")],
            "image" => ["nullable", "image"],
            "title" => ["nullable", "string"],
            "description" => ["nullable", "string"],
            "url" => ["nullable", "url"],
            "image" => ["nullable", "image"],
            "token" => ["required", "string"],
            "user_id" => ["required", Rule::exists("users","id")],
            "location_id" => ["nullable", Rule::exists("locations","id")],
        ];
    }
}
