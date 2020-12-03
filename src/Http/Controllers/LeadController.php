<?php

namespace Agenciafmd\Leads\Http\Controllers;

use Agenciafmd\Admix\Http\Filters\GreaterThanFilter;
use Agenciafmd\Admix\Http\Filters\LowerThanFilter;
use Agenciafmd\Leads\Http\Requests\LeadRequest;
use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Rap2hpoutre\FastExcel\FastExcel;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $query = QueryBuilder::for(Lead::class)
            ->defaultSorts(config('admix-leads.default_sort'))
            ->allowedSorts($request->sort)
            ->allowedFilters(array_merge((($request->filter) ? array_keys(array_diff_key($request->filter, array_flip(['id', 'is_active', 'source', 'created_at_gt', 'created_at_lt']))) : []), [
                AllowedFilter::exact('id'),
                AllowedFilter::exact('is_active'),
                AllowedFilter::exact('source'),
                AllowedFilter::custom('created_at_gt', new GreaterThanFilter),
                AllowedFilter::custom('created_at_lt', new LowerThanFilter),
            ]));

        if ($request->is('*/trash')) {
            $query->onlyTrashed();
        }

        $view['sources'] = $this->sources();

        $view['items'] = $query->paginate($request->get('per_page', 50));

        return view('agenciafmd/leads::index', $view);
    }

    public function create(Lead $lead)
    {
        $view['model'] = $lead;
        $view['sources'] = $this->sources();

        return view('agenciafmd/leads::form', $view);
    }

    public function store(LeadRequest $request)
    {
        if ($lead = Lead::create($request->validated())) {
            flash('Item inserido com sucesso.', 'success');
        } else {
            flash('Falha no cadastro.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.leads.index');
    }

    public function show(Lead $lead)
    {
        $view['model'] = $lead;
        $view['sources'] = $this->sources();

        return view('agenciafmd/leads::form', $view);
    }

    public function edit(Lead $lead)
    {
        $view['model'] = $lead;
        $view['sources'] = $this->sources();

        return view('agenciafmd/leads::form', $view);
    }

    public function update(Lead $lead, LeadRequest $request)
    {
        if ($lead->update($request->validated())) {
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

    public function batchExport($all = null, Request $request)
    {
        $query = Lead::query()
            ->select([
                'id AS Código',
                'source AS Origem',
                'name AS Nome',
                'email AS E-mail',
                'phone AS Telefone',
                'description AS Descrição',
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y %H:%i") AS Data')]);
        if (!$all) {
            $query->whereIn('id', $request->get('id', []));
        }
        $leads = $query->get();

        return (new FastExcel($leads))->download('relatorio-leads.xlsx');
    }

    private function sources()
    {
        return Postal::pluck('name', 'slug')
            ->toArray();
    }
}
