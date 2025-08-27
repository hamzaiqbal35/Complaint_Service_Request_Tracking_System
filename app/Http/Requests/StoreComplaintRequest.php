<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check() && auth()->user()->isUser(); }

    public function rules(): array {
        return [
            'category_id' => ['required','exists:categories,id'],
            'title' => ['required','string','max:255'],
            'description' => ['required','string','max:5000'],
            'priority' => ['required','in:low,medium,high'],
        ];
    }
}


