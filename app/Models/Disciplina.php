<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    public function curso() {
        return $this->belongsTo('App\Models\Curso');  
    }

    public function professor() {
        return $this->belongsTo('App\Models\Professor', 'matriculas')->withPivot('descricao');
    }
}
