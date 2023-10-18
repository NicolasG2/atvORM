<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
   
    public function index()
    {
        $data = Disciplina::orderBy('nome')->get();
        return view('disciplinas.index', compact('data'));
    }

    
    public function create()
    {
        $curso_id = Curso::all();
        return view('disciplinas.create')->with('curso_id', $curso_id);
    }

    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:100|min:10',
            'curso_id' => 'required',
            'carga' => 'required|max:12|min:1',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $curso_id = $request->input('curso');
        $curso = Curso::where('nome', $curso_id)->first();

        if ($request->validate($regras, $msgs)) {
            $curso_id = $request->input('curso_id');
            $curso = Curso::where('nome', $curso_id)->first();
    
            if ($curso) {
                $reg = new Disciplina();
                $reg->nome = $request->nome;
                $reg->carga = $request->carga;
                $reg->curso_id = $curso->id;

                $reg->save();
                return redirect()->route('disciplinas.index')->with('success', 'Disciplina cadastrada com sucesso');
            } else {
                return back()->with('error', 'Curso não encontrado');
            }
        } else {
            return back()->withInput()->withErrors($request->validate($regras, $msgs));
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados = Disciplina::find($id);
        $curso_id = Curso::all();

        if(!isset($dados)) { 
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('disciplinas.edit', compact('dados', 'curso_id'));    
    }

    public function update(Request $request, $id) {
     
        $regras = [
            'nome' => 'required|max:50|min:10',
            'carga' => 'required|max:12|min:1',
            'curso_id' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Disciplina::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $curso = Curso::where('nome', $request->input('curso_id'))->first();

        if ($curso) {
            $reg->nome = $request->nome;
            $reg->carga = $request->carga;
            $reg->curso_id = $curso->id;

            $reg->save();

            return redirect()->route('disciplinas.index')->with('success', 'Disciplina atualizada com sucesso');
        } else {
            return back()->with('error', 'Curso não encontrado');
        }
    }

    
    public function destroy($id)
    {
        $reg=Disciplina::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->destroy($id);

        return redirect()->route('disciplinas.index');
    }
}
