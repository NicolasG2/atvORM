<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    public function curso() {
        return $this->belongsTo('App\Models\Curso');  
    }

    public function disciplina() {
        return $this->belongsTo('App\Models\Disciplina', 'matriculas')->withPivot('descricao');;;  
    }
}
