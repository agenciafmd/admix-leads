@extends('agenciafmd/admix::partials.crud.form')

@section('form')
    <x-admix::cards.form title="{{ config('admix-leads.name') }}"
                         :create="route('admix.leads.store')"
                         :update="route('admix.leads.update', ['lead' => ($model->id) ?? 0])">
        <x-admix::forms.list-group>
            <x-admix::forms.group label="ativo" for="is_active">
                <x-admix::forms.boolean name="is_active" required="required" :selected="$model->is_active ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="origem" for="source">
                <x-admix::forms.select name="source" :options="['' => '-'] + $sources + config('admix-leads.sources')"
                                       :selected="$model->source ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="nome" for="name">
                <x-admix::forms.input name="name" :value="$model->name ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="email" for="email">
                <x-admix::forms.email name="email" :value="$model->email ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="telefone" for="phone">
                <x-admix::forms.input name="phone" class="mask-phone" :value="$model->phone ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="descrição" for="description" multiple="true">
                <x-admix::forms.mde name="description">{{ $model->description ?? null }}</x-admix::forms.mde>
            </x-admix::forms.group>

        </x-admix::forms.list-group>
    </x-admix::cards.form>
@endsection
