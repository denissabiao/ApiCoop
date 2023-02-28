<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Consulta extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'idmedico' => $this->idmedico,
            'medico' => $this->medico,
            'data' => $this->data,
            'horario' => $this->horario,
            'marcado' => $this->marcado
        ];
    }
}