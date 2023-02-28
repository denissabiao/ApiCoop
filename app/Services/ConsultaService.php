<?php

namespace App\Services;

use App\Http\Resources\Consulta as ResourcesConsulta;
use App\Models\Consulta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class ConsultaService extends Model
{
    public static function getAppointmentDateLimit(string $data, int $limite)
    {
        return Carbon::create($data)->addDays($limite)->format('Y-m-d');
    }

    public function allAppointmentByMedic(Request $request, string $data_limite)
    {
        return ResourcesConsulta::collection(Consulta::whereBetween('data', array($request->query('data'), $data_limite))
            ->where('idmedico', $request->query('idmedico'))
            ->where('marcado', 0)
            ->orderBy('medico')
            ->orderBy('data')
            ->orderBy('horario')
            ->get());
    }

    public function mapAppointmentMedic($consulta_medico)
    {
        $novo_array = [];
        $consulta_medico->map(function ($item) use (&$novo_array) {
            self::addItemToNewArray($novo_array, $item);
        });

        return $novo_array;
    }

    private static function addItemToNewArray(&$novo_array, $item)
    {
        $data = $item['data'];
        $id = $item['id'];
        $horario = $item['horario'];

        $novo_array[$data][] = [$id => $horario];
        $novo_array[$data]['quantidade_horario'] = array_key_last($novo_array[$data]) + 1;
        $novo_array[$data]['medico'] = $item['medico'];
    }

}