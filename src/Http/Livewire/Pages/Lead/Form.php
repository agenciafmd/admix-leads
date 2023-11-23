<?php

namespace Agenciafmd\Leads\Http\Livewire\Pages\Lead;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;

class Form extends Component
{
    use AuthorizesRequests;

    public Lead $model;
    public array $sourceOptions;

    public function mount(Lead $lead): void
    {
        ($lead->id) ? $this->authorize('update', Lead::class) : $this->authorize('create', Lead::class);

        $this->model = $lead;
        $this->model->is_active ??= false;
        $this->sourceOptions = $this->sources();
    }

    public function rules(): array
    {
        return [
            'model.is_active' => [
                'boolean',
            ],
            'model.source' => [
                'nullable',
                'max:255',
            ],
            'model.name' => [
                'nullable',
                'max:255',
            ],
            'model.email' => [
                'nullable',
                'email:rfc,dns',
                'max:255',
            ],
            'model.phone' => [
                'nullable',
                'max:255',
            ],
            'model.description' => [
                'nullable',
            ],
        ];
    }

    public function attributes(): array
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

    public function submit(): null|RedirectResponse|Redirector
    {
        $this->validate($this->rules(), [], $this->attributes());

        try {
            if ($this->model->save()) {
                flash(__('crud.success.save'), 'success');
            } else {
                flash(__('crud.error.save'), 'error');
            }

            return redirect()->to(session()->get('backUrl') ?: route('admix.leads.index'));
        } catch (\Exception $exception) {
            $this->emit('toast', [
                'level' => 'danger',
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public function render(): View
    {
        return view('admix-leads::pages.lead.form')
            ->extends('admix::internal')
            ->section('internal-content');
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field, $this->rules(), [], $this->attributes());
    }

    private function sources(): array
    {
        if (!class_exists(Postal::class)) {
            return [];
        }

        return Postal::query()
            ->pluck('name', 'slug')
            ->toArray();
    }
}
