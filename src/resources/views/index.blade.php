@extends('agenciafmd/admix::partials.crud.index', [
    'route' => (request()->is('*/trash') ? route('admix.leads.trash') : route('admix.leads.index'))
])

@section('title')
    @if(request()->is('*/trash'))
        Lixeira de
    @endif
    {{ config('admix-leads.name') }}
@endsection

@section('actions')
    @if(request()->is('*/trash'))
        @include('agenciafmd/admix::partials.btn.back', ['url' => route('admix.leads.index')])
    @else
        @can('create', '\Agenciafmd\Leads\Lead')
            @include('agenciafmd/admix::partials.btn.create', ['url' => route('admix.leads.create'), 'label' => config('admix-leads.name')])
        @endcan
        @can('restore', '\Agenciafmd\Leads\Lead')
            @include('agenciafmd/admix::partials.btn.trash', ['url' => route('admix.leads.trash')])
        @endcan
    @endif
@endsection

@section('batch')
    @if(request()->is('*/trash'))
        @can('restore', '\Agenciafmd\Leads\Lead')
            {{ Form::select('batch', ['' => 'com os selecionados', route('admix.leads.batchRestore') => '- restaurar'], null, ['class' => 'js-batch-select form-control custom-select']) }}
        @endcan
    @else
        @can('delete', '\Agenciafmd\Leads\Lead')
            {{ Form::select('batch', ['' => 'com os selecionados', route('admix.leads.batchDestroy') => '- remover'], null, ['class' => 'js-batch-select form-control custom-select']) }}
        @endcan
    @endif
@endsection

@section('filters')
    <h6 class="dropdown-header bg-gray-lightest p-2">Email</h6>
    <div class="p-2">
        {{ Form::text('filter[email]', filter('email'), [
                'class' => 'form-control form-control-sm'
            ]) }}
    </div>
    <h6 class="dropdown-header bg-gray-lightest p-2">Telefone</h6>
    <div class="p-2">
        {{ Form::text('filter[phone]', filter('phone'), [
                'class' => 'form-control form-control-sm'
            ]) }}
    </div>
@endsection

@section('table')
    @if($items->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-borderless table-vcenter card-table text-nowrap">
                <thead>
                <tr>
                    <th class="w-1 d-none d-md-table-cell">&nbsp;</th>
                    <th class="w-1">{!! column_sort('#', 'id') !!}</th>
                    <th>{!! column_sort('Nome', 'name') !!}</th>
                    <th>{!! column_sort('Email', 'email') !!}</th>
                    <th>{!! column_sort('Telefone', 'phone') !!}</th>
                    <th>{!! column_sort('Status', 'is_active') !!}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <label class="mb-1 custom-control custom-checkbox">
                                <input type="checkbox" class="js-check custom-control-input"
                                       name="check[]" value="{{ $item->id }}">
                                <span class="custom-control-label">&nbsp;</span>
                            </label>
                        </td>
                        <td><span class="text-muted">{{ $item->id }}</span></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            @include('agenciafmd/admix::partials.label.status', ['status' => $item->is_active])
                        </td>
                        @if(request()->is('*/trash'))
                            <td class="w-1 text-right">
                                @include('agenciafmd/admix::partials.btn.restore', ['url' => route('admix.leads.restore', $item->id)])
                            </td>
                        @else
                            <td class="w-1 text-center">
                                <div class="item-action dropdown">
                                    <a href="#" data-toggle="dropdown" class="icon">
                                        <i class="icon fe-more-vertical text-muted"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @include('agenciafmd/admix::partials.btn.show', ['url' => route('admix.leads.show', $item->id)])
                                        @can('update', '\Agenciafmd\Leads\Lead')
                                            @include('agenciafmd/admix::partials.btn.edit', ['url' => route('admix.leads.edit', $item->id)])
                                        @endcan
                                        @can('delete', '\Agenciafmd\Leads\Lead')
                                            @include('agenciafmd/admix::partials.btn.remove', ['url' => route('admix.leads.destroy', $item->id)])
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $items->appends(request()->except(['page']))->links() !!}
    @else
        @include('agenciafmd/admix::partials.info.not-found')
    @endif
@endsection
