<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreVideoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => [
                'required', 'string',
            ],
            'description' => [
                'required', 'string',
            ],
            'subject' => [
                'required', 'string',
            ],
        ];
    }

    public function authorize()
    {
        return Gate::allows('video_access');
    }
}
