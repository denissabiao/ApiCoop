<?php

namespace App\Http\Controllers;

use App\Http\Resources\Especialidade as ResourcesEspecialidade;
use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    protected $especialidadeService;

    public function index()
    {
        return ResourcesEspecialidade::collection(Especialidade::orderBy('especialidade')->get());
    }

}