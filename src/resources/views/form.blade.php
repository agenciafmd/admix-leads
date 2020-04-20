@extends('agenciafmd/admix::partials.crud.form')

@section('form')
    {{ Form::bsOpen(['model' => optional($model), 'create' => route('admix.leads.store'), 'update' => route('admix.leads.update', ['lead' => ($model->id) ?? 0])]) }}
    <div class="card-header bg-gray-lightest">
        <h3 class="card-title">
            @if(request()->is('*/create'))
                Criar
            @elseif(request()->is('*/edit'))
                Editar
            @else
                Visualizar
            @endif
            {{ config('admix-leads.name') }}
        </h3>
        <div class="card-options">
            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    <ul class="list-group list-group-flush">

        @if (optional($model)->id)
            {{ Form::bsText('Código', 'id', null, ['disabled' => true]) }}
        @endif

        {{ Form::bsIsActive('Ativo', 'is_active', null, ['required']) }}

        {{ Form::bsSelect('Origem', 'source', ['' => '-'] + $sources + config('admix-leads.sources'), null) }}

        {{ Form::bsText('Nome', 'name', null) }}

        {{ Form::bsEmail('E-mail', 'email', null) }}

        {{ Form::bsText('Telefone', 'phone', null, ['class' => 'mask-phone']) }}

        {{ Form::bsTextarea('Descrição', 'description', null) }}
    </ul>
    <div class="card-footer bg-gray-lightest text-right">
        <div class="d-flex">
            @include('agenciafmd/admix::partials.btn.back')

            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    {{ Form::close() }}
@endsection
