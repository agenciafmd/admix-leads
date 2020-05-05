<?php

namespace Agenciafmd\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    protected $errorBag = 'admix';

    public function rules()
    {
        return [
            'is_active' => ['required', 'boolean'],
            'source' => ['nullable', 'max:150'],
            'name' => ['nullable', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'max:150'],
            'description' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'is_active' => 'ativo',
            'source' => 'fonte',
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
