<?php

namespace App\Http\Controllers;

use App\Http\Resources\Convenio as ResourcesConvenio;
use App\Models\Convenio;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
    public function index()
    {
        return ResourcesConvenio::collection(Convenio::orderBy('nome')->get());
    }

}