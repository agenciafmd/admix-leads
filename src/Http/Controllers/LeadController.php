<?php

namespace Agenciafmd\Leads\Http\Controllers;

use Agenciafmd\Admix\Http\Filters\GreaterThanFilter;
use Agenciafmd\Admix\Http\Filters\LowerThanFilter;
use Agenciafmd\Leads\Http\Requests\LeadRequest;
use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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

    public function batchExport(Request $request)
    {
        set_time_limit(60*2);

        $sources = $this->sources();
        $nameFile = "relatorio-leads.xlsx";
        $nameFileFull = storage_path($nameFile);

        Settings::setCache(app('cache.store'));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Origem');
        $sheet->setCellValue('B1', 'Nome');
        $sheet->setCellValue('C1', 'E-mail');
        $sheet->setCellValue('D1', 'Telefone');
        $sheet->setCellValue('E1', 'Descrição');
        $sheet->setCellValue('F1', 'Data');

        $leads = Lead::whereIn('id', $request->get('id', []))
            ->cursor();

        // TODO: refatorar com each de collection
        foreach ($leads as $k => $lead) {
            $cont = $k + 2;
            $sheet->setCellValue('A' . $cont, ($sources[$lead->source]) ?? $lead->source);
            $sheet->setCellValue('B' . $cont, $lead->name);
            $sheet->setCellValue('C' . $cont, $lead->email);
            $sheet->setCellValue('D' . $cont, $lead->phone);
            $sheet->setCellValue('E' . $cont, $lead->description);
            $sheet->setCellValue('F' . $cont, $lead->created_at->format('d/m/Y H:i'));
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($nameFileFull);

        return response()->download($nameFileFull, $nameFile);
    }

    private function sources()
    {
        return Postal::pluck('name', 'slug')
            ->toArray();
    }
}
