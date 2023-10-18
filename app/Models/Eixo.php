<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Eixo extends Model
{
    use HasFactory;

    public function curso() {
        return $this->BelongsToMany('App\Models\Curso');
    }

    public function professor() {
        return $this->belongsToMany('App\Models\Professor');
    }
}
