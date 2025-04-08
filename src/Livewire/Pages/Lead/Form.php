<?php

namespace Agenciafmd\Leads\Livewire\Pages\Lead;

use Agenciafmd\Leads\Models\Lead;
use Livewire\Attributes\Validate;
use Livewire\Form as LivewireForm;

class Form extends LivewireForm
{
    public Lead $lead;

    #[Validate]
    public bool $is_active = true;

    #[Validate]
    public string $source = '';

    #[Validate]
    public ?string $name = null;

    #[Validate]
    public string $email = '';

    #[Validate]
    public ?string $phone = null;

    #[Validate]
    public ?string $description = null;

    public function setModel(Lead $lead): void
    {
        $this->lead = $lead;
        if ($lead->exists) {
            $this->is_active = $lead->is_active;
            $this->source = $lead->source;
            $this->name = $lead->name;
            $this->email = $lead->email;
            $this->phone = $lead->phone;
            $this->description = $lead->description;
        }
    }

    public function rules(): array
    {
        return [
            'is_active' => [
                'boolean',
            ],
            'source' => [
                'nullable',
                'max:255',
            ],
            'name' => [
                'nullable',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'max:255',
            ],
            'description' => [
                'nullable',
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'is_active' => __('admix-leads::fields.is_active'),
            'source' => __('admix-leads::fields.source'),
            'name' => __('admix-leads::fields.name'),
            'email' => __('admix-leads::fields.email'),
            'phone' => __('admix-leads::fields.phone'),
            'description' => __('admix-leads::fields.description'),
        ];
    }

    public function save(): bool
    {
        $this->validate(rules: $this->rules(), attributes: $this->validationAttributes());
        $this->lead->fill($this->except('lead'));

        return $this->lead->save();
    }
}
