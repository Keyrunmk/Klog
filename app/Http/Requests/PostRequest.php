<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => ["required", "max:255"],
            "slug" => ["required", Rule::unique("posts", "slug")->ignore($this->post)],
            "body" => ["required", "max:255"],
            "category_id" => ["required", Rule::exists("categories", "id")],
            "image" => ["nullable", "image"],
        ];
    }
}
