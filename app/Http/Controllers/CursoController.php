<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Eixo;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $data = Curso::orderBy('nome')->get();
        return view('cursos.index', compact('data'));
    }

    
    public function create()
    {
        $eixo_id = Eixo::all();
        return view('cursos.create')->with('eixo_id', $eixo_id);
    }

    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:50|min:10',
            'sigla' => 'required|max:8|min:2',
            'tempo' => 'required|max:2|min:1',
            'eixo_id' => 'required'
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
                $reg = new Curso();
                $reg->nome = $request->nome;
                $reg->sigla = $request->sigla;
                $reg->tempo = $request->tempo;
                $reg->eixo_id = $eixo->id;
                $reg->save();
                return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso');
            } else {
                return back()->with('error', 'Eixo não encontrado');
            }
        } else {
            return back()->withInput()->withErrors($request->validate($regras, $msgs));
        }
    }
    
    public function show($id)
    {
        
    }

    
    public function edit($id)
    {
        $dados = Curso::find($id);

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('cursos.edit', compact('dados'));    
    }

    public function update(Request $request, $id) {
     
        $regras = [
            'nome' => 'required|max:50|min:10',
            'sigla' => 'required|max:8|min:2',
            'tempo' => 'required|max:2|min:1',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Curso::find($id);
        
        if(isset($reg)) {
            $reg->nome = $request->nome;
            $reg->sigla = $request->sigla;
            $reg->tempo = $request->tempo;
            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }
    
        return redirect()->route('cursos.index');
    }

    
    public function destroy($id)
    {
        $reg=Curso::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->destroy($id);

        return redirect()->route('eixo.index');
    }
}