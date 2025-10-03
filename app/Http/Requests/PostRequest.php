<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];

    //      if ($this->method() === 'POST') {
    //     // Áp dụng quy tắc cho CREATE (POST)
    //     $rules['title'] = ['required', 'string', 'max:255', 'unique:posts,title'];
    // }
    // // Kiểm tra xem đây có phải là request Cập nhật (update) không
    // if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
    //     // Lấy ID của bài post từ route để loại trừ
    //     $postId = $this->route('post')->id; 
    //     // Áp dụng quy tắc cho UPDATE (PUT/PATCH), loại trừ bản ghi hiện tại
    //     $rules['title'] = ['required', 'string', 'max:255', "unique:posts,title,{$postId}"];
    // }

        return $rules;
    }
}
