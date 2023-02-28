<?php

namespace App\Http\Controllers;

use App\Http\Resources\Medico as ResourcesMedico;
use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{

    public function index()
    {
        return ResourcesMedico::collection(Medico::orderBy('medico')->get());
    }

    public function buscaMedicoPelaEspecialidade($especialidade)
    {
        return ResourcesMedico::collection(Medico::where('especialidade', $especialidade)->orderBy('medico')->get());
    }


    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        return new ResourcesMedico(Medico::findOrFail($id));
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        return 1;
    }
}