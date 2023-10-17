<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $data = Matricula::orderBy('nome')->get();
        return view('matricula.index', compact('data'));
    }

    
    public function create()
    {
        return view('matricula.create');
    }

    
    public function store(Request $request)
    {
        $regras = [
            'professor_id' => 'required',
            'disciplina_id' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = new Matricula();
        $reg->professor_id = $request->professor_id;
        $reg->disciplina_id = $request->disciplina_id;
        $reg->save();       
        
        return redirect()->route('matricula.index');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados = Matricula::find($id);

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('matricula.edit', compact('dados'));    
    }

    public function update(Request $request, $id) {
     
        $regras = [
            'professor_id' => 'required',
            'disciplina_id' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Matricula::find($id);
        
        if(isset($reg)) {
            $reg->professor_id = $request->professor_id;
            $reg->disciplina_id = $request->disciplina_id;
            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('matricula.index');
    }

    
    public function destroy($id)
    {
        $reg=Matricula::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->destroy($id);

        return redirect()->route('matricula.index');
    }
}
