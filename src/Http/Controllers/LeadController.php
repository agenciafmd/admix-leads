<?php

namespace Agenciafmd\Leads\Http\Controllers;

use Agenciafmd\Leads\Http\Requests\LeadRequest;
use Agenciafmd\Leads\Lead;
use Agenciafmd\Postal\Postal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        $nameFile = "relatorio-leads.xlsx";
        $nameFileFull = storage_path("relatorio-leads.xlsx");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Origem');
        $sheet->setCellValue('B1', 'Nome');
        $sheet->setCellValue('C1', 'E-mail');
        $sheet->setCellValue('D1', 'Telefone');
        $sheet->setCellValue('E1', 'Descrição');
        $sheet->setCellValue('F1', 'Data');

        $leads = Lead::whereIn('id', $request->get('id', []))
            ->get();;

        foreach ($leads as $k => $lead) {
            $cont = $k + 2;
            $sheet->setCellValue('A' . $cont, ($sources[$item->source]) ?? $item->source);
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
