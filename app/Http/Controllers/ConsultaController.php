<?php

namespace App\Http\Controllers;

use App\Http\Resources\Consulta as ResourcesConsulta;
use App\Models\Consulta;
use App\Services\ConsultaService;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{

    protected $consultaService;

    public function __construct(ConsultaService $consultaServicee)
    {
        $this->consultaService = $consultaServicee;
    }

    public function index()
    {
        return Consulta::paginate(15);
    }

    public function buscaConsultaPelaEspecialidadeEData(Request $request)
    {
        $especialidade = $request->query('especialidade');
        $data = $request->query('data');


        if (!$especialidade || !$data) {
            return response()->json(['message' => 'Missing search parameters.'], 400);
        }


        $data_limite = $this->consultaService::getAppointmentDateLimit($data, 5);


        $consultas = Consulta::selectraw('id,idmedico,medico,data,horario')
            ->where('especialidade', $especialidade)
            ->whereBetween('data', array($data, $data_limite))
            ->where('marcado', 0)
            ->orderBy('medico')
            ->orderBy('data')
            ->orderBy('horario')
            ->get();

        $consultas_formated = [];

        $consultas->map(function ($item, $key) use (&$consultas_formated) {
            $consultas_formated[$item['data']][$item['idmedico']][][$item['id']] = $item['horario'];

            $quantiadade_consultas_medicos = array_key_last($consultas_formated[$item['data']][$item['idmedico']]) + 1;


            $consultas_formated[$item['data']][$item['idmedico']]['dados']['quantidade_consultas'] = $quantiadade_consultas_medicos;
            $consultas_formated[$item['data']][$item['idmedico']]['dados']['medico'] = $item['medico'];

        });

        return $consultas_formated;
    }


    public function getAppointmentByMedic(Request $request)
    {
        $data_limite = $this->consultaService::getAppointmentDateLimit($request->query('data'), 5);

        $consulta_medico = $this->consultaService->getAppointmentMedic($request, $data_limite);

        return $consulta_medico;
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        return new ResourcesConsulta(Consulta::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}