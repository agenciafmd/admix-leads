<?php

namespace Agenciafmd\Leads\Http\Controllers;

use Agenciafmd\Leads\Http\Requests\LeadRequest;
use Agenciafmd\Leads\Lead;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $query = QueryBuilder::for(Lead::class)
            ->defaultSorts(config('admix-leads.default_sort'))
            ->allowedSorts($request->sort)
            ->allowedFilters((($request->filter) ? array_keys($request->get('filter')) : []));

        if ($request->is('*/trash')) {
            $query->onlyTrashed();
        }

        $view['items'] = $query->paginate($request->get('per_page', 50));

        return view('agenciafmd/leads::index', $view);
    }

    public function create(Lead $lead)
    {
        $view['model'] = $lead;

        return view('agenciafmd/leads::form', $view);
    }

    public function store(LeadRequest $request)
    {
        if ($lead = Lead::create($request->all())) {
            flash('Item inserido com sucesso.', 'success');
        } else {
            flash('Falha no cadastro.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }

    public function show(Lead $lead)
    {
        $view['model'] = $lead;

        return view('agenciafmd/leads::form', $view);
    }

    public function edit(Lead $lead)
    {
        $view['model'] = $lead;

        return view('agenciafmd/leads::form', $view);
    }

    public function update(Lead $lead, LeadRequest $request)
    {
        if ($lead->update($request->all())) {
            flash('Item atualizado com sucesso.', 'success');
        } else {
            flash('Falha na atualização.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }

    public function destroy(Lead $lead)
    {
        if ($lead->delete()) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }

    public function restore($id)
    {
        $lead = Lead::onlyTrashed()
            ->find($id);

        if (!$lead) {
            flash('Item já restaurado.', 'danger');
        } elseif ($lead->restore()) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }

    public function batchDestroy(Request $request)
    {
        if (Lead::destroy($request->get('id', []))) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }

    public function batchRestore(Request $request)
    {
        $lead = Lead::onlyTrashed()
            ->whereIn('id', $request->get('id', []))
            ->restore();

        if ($lead) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }
}
