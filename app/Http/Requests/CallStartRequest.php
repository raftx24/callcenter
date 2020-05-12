<?php

namespace App\Http\Requests;

use App\Enums\CallPriority;
use Illuminate\Foundation\Http\FormRequest;

class CallStartRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone_number' => 'required',
            'priority' => 'required|numeric|in:'. implode(',', CallPriority::values())
        ];
    }
}
