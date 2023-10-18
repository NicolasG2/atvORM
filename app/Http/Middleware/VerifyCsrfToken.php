<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        
        "eixos/add",
        "cursos/add",
        "professors/add",
        "disciplinas/add",
        "alunos/add",
        "matricula/add",
        "matricula/aluno",
        "docencia/add",
    ];
}
