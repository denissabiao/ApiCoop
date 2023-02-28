<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
         'idmedico',
         'id_paciente',
         'paciente',
         'medico',
         'data',
         'horario',
         'convenio',
         'telefone',
         'telefone_2',
         'operador',
         'especialidade',
          'marcado',
          'obs',
          'tipo',
          'data_marcacao',
          'tipo_2',
          'agenda_online',
          'agenda_cpf',
          'usu_cancelar',
    ];

    protected $table = 'dbagenda';

}
