<?php

namespace Agenciafmd\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontendRequest extends FormRequest
{
    protected $errorBag = 'leads';

    public function rules()
    {
        return [
            'hp_name' => [
                'honeypot',
            ],
            'hp_time' => [
                'required',
                'honeytime:5',
            ],

            'source' => [
                'nullable',
                'max:150',
            ],
            'name' => [
                'nullable',
                'max:150',
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'phone' => [
                'nullable',
                'max:150',
            ],
            'description' => [
                'nullable',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'source' => 'origem',
            'name' => 'nome',
            'phone' => 'telefone',
            'description' => 'descrição',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
