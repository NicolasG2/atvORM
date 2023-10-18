<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    public function eixo() {
        return $this->belongsTo('App\Models\Eixo');  
    }

    public function disciplina() {
        return $this->belongsTo('App\Models\Disciplina', 'docencia')->withPivot('descricao');
    }
}
