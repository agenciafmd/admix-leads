<?php

namespace Agenciafmd\Leads\Livewire\Pages\Lead;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Livewire\Component as LivewireComponent;
use Livewire\Features\SupportRedirects\Redirector;

class Component extends LivewireComponent
{
    use AuthorizesRequests;

    public Form $form;

    public Lead $lead;

    public array $sourceOptions;

    public function mount(Lead $lead): void
    {
        ($lead->exists) ? $this->authorize('update', Lead::class) : $this->authorize('create', Lead::class);

        $this->lead = $lead;
        $this->form->setModel($lead);
        $this->sourceOptions = $this->getSourceOptions();
    }

    public function submit(): null|Redirector|RedirectResponse
    {
        try {
            if ($this->form->save()) {
                flash(($this->lead->exists) ? __('crud.success.save') : __('crud.success.store'), 'success');
            } else {
                flash(__('crud.error.save'), 'error');
            }

            return redirect()->to(session()->get('backUrl') ?: route('admix.lead.index'));
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->dispatch(event: 'toast', level: 'danger', message: $exception->getMessage());
        }

        return null;
    }

    public function render(): View
    {
        return view('admix-leads::pages.lead.form')
            ->extends('admix::internal')
            ->section('internal-content');
    }

    private function getSourceOptions(): array
    {
        if (!class_exists(Postal::class)) {
            return [
                'label' => '-',
                'value' => '',
            ];
        }

        /* Criar a macro de ->toOptions('label', 'value', 'texto do primeiro item vazio do select. Esse usado no preprend') */
        return Postal::query()
            ->select(['name', 'slug'])
            ->sort()
            ->get()
            ->map(fn ($postal) => [
                'label' => $postal->name,
                'value' => $postal->slug,
            ])
            ->prepend([
                'label' => '-',
                'value' => '',
            ])
            ->toArray();
    }
}
