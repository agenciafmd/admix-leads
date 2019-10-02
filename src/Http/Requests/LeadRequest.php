<?php

namespace Agenciafmd\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'is_active' => 'required|boolean',
            'name' => 'nullable|max:150',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|max:150',
            'description' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'is_active' => 'ativo',
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
