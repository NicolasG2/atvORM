<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AlunoController extends Controller
{

    public function index()
    {
        $data = Aluno::orderBy('nome')->get();
        return view('alunos.index', compact('data'));
    }

    
    public function create()
    {
        $curso_id = Curso::all();
        return view('alunos.create')->with('curso_id', $curso_id);
    }

    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:100|min:10',
            'curso_id' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $curso_id = $request->input('curso');
        $curso = Curso::where('nome', $curso_id)->first();

        if ($curso) {
            $reg = new Aluno();
            $reg->nome = $request->nome;
            $reg->curso_id = $curso->id;

            $reg->save();
            return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso');
        } else {
            return back()->with('error', 'Curso não encontrado');
        }

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados = Aluno::find($id);
        $curso_id = Curso::all();

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('alunos.edit', compact('dados', 'curso_id'));    
    }

    public function update(Request $request, $id) {
     
        $regras = [
            'nome' => 'required|max:100|min:10',
            'curso_id' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Aluno::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $curso = Curso::where('nome', $request->input('curso_id'))->first();

        if ($curso) {
            $reg->nome = $request->nome;
            $reg->curso_id = $curso->id;

            $reg->save();

            return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso');
        } else {
            return back()->with('error', 'Curso não encontrado');
        }
    }

    
    public function destroy($id)
    {
        $reg=Aluno::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->destroy($id);

        return redirect()->route('alunos.index');
    }
}
