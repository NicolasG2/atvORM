<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        $data = Professor::orderBy('nome')->get();
        return view('professors.index', compact('data'));
    }

    
    public function create()
    {
        $eixo_id = Eixo::all();
        return view('professors.create')->with('eixo_id', $eixo_id);
    }

    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:50|min:10',
            'email' => 'required|max:250|min:15',
            'siape' => 'required|max:10|min:8',
            'eixo_id' => 'required',
            'ativo' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $eixo_id = $request->input('eixo');
        $eixo = Eixo::where('nome', $eixo_id)->first();

        if ($request->validate($regras, $msgs)) {
            $eixo_id = $request->input('eixo_id');
            $eixo = Eixo::where('nome', $eixo_id)->first();
    
            if ($eixo) {
                $reg = new Professor();
                $reg->nome = $request->nome;
                $reg->email = $request->email;
                $reg->siape = $request->siape;
                $reg->eixo_id = $eixo->id;
                $reg->ativo = $request->ativo;

                $reg->save();
                return redirect()->route('professors.index')->with('success', 'Professor cadastrado com sucesso');
            } else {
                return back()->with('error', 'Eixo não encontrado');
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
        $dados = Professor::find($id);
        $eixo_id = Eixo::all();

        if(!isset($dados)) { 
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('professors.edit', compact('dados', 'eixo_id'));    
    }

    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|max:50|min:10',
            'email' => 'required|max:250|min:15',
            'eixo_id' => 'required',
            'ativo' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Professor::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $eixo = Eixo::where('nome', $request->input('eixo_id'))->first();

        if ($eixo) {
            $reg->nome = $request->nome;
            $reg->email = $request->email;
            $reg->eixo_id = $eixo->id;
            $reg->ativo = $request->ativo;

            $reg->save();

            return redirect()->route('professors.index')->with('success', 'Professor atualizado com sucesso');
        } else {
            return back()->with('error', 'Eixo não encontrado');
        }
    }

    
    public function destroy($id)
    {
        $reg=Professor::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->destroy($id);

        return redirect()->route('professors.index');
    }
}
