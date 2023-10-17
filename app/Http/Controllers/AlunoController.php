<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{

    public function index()
    {
        $data = Aluno::orderBy('nome')->get();
        return view('aluno.index', compact('data'));
    }

    
    public function create()
    {
        return view('aluno.create');
    }

    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:100|min:10',
            'curso' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = new Aluno();
        $reg->nome = $request->nome;
        $reg->curso = $request->curso;
        $reg->save();       
        
        return redirect()->route('aluno.index');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados = Aluno::find($id);

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('aluno.edit', compact('dados'));    
    }

    public function update(Request $request, $id) {
     
        $regras = [
            'nome' => 'required|max:100|min:10',
            'curso' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Aluno::find($id);
        
        if(isset($reg)) {
            $reg->nome = $request->nome;
            $reg->curso = $request->curso;
            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('aluno.index');
    }

    
    public function destroy($id)
    {
        $reg=Aluno::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->destroy($id);

        return redirect()->route('aluno.index');
    }
}
