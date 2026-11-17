<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::upcoming()->paginate(10);
        $pastAgendas = Agenda::past()->take(5)->get();
        return view('agendas.index', compact('agendas', 'pastAgendas'));
    }
}