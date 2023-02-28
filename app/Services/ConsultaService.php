<?php

namespace App\Services;

use App\Http\Resources\Consulta as ResourcesConsulta;
use App\Models\Consulta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ConsultaService extends Model
{
    public static function getAppointmentDateLimit(string $data, int $limite)
    {
        return Carbon::create($data)->addDays($limite)->format('Y-m-d');
    }

    public function getAppointmentMedic(Request $request, int $data_limite)
    {
        return ResourcesConsulta::collection(Consulta::whereBetween('data', array($request->query('data'), $data_limite))
            ->where('idmedico', $request->query('idmedico'))
            ->where('marcado', 0)
            ->orderBy('medico')
            ->orderBy('data')
            ->orderBy('horario')
            ->get());
    }

}