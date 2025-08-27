<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintStatusRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isStaff()); }

    public function rules(): array {
        return [
            'status' => ['required','in:pending,in_progress,resolved,rejected'],
            'message' => ['nullable','string','max:2000'],
        ];
    }
}


