<?php

namespace Agenciafmd\Leads\Http\Controllers;

use Agenciafmd\Leads\Http\Requests\FrontendRequest;
use Agenciafmd\Leads\Lead;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function store(FrontendRequest $request)
    {
        //session()->put('backUrl', request()->fullUrl());

        $lead = Lead::when($request->email, function ($query) use ($request) {
            $query->where('email', $request->email);
        })
            ->when($request->phone, function ($query) use ($request) {
                $query->where('phone', $request->phone);
            })
            ->first();

        if (!$lead) {
            $lead = new Lead();
        }

        if ($request->name) {
            $lead->name = $request->name;
        }

        if ($request->email) {
            $lead->email = $request->email;
        }

        if ($request->phone) {
            $lead->phone = $request->phone;
        }

        if ($request->description) {
            $lead->description = $request->description;
        }

        if ($lead->save()) {
            flash('Obrigado por se cadastrar.')->success();
        } else {
            flash('Falha no cadastro.')->warning();
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('frontend.index');
    }
}
