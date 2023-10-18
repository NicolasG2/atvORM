<?php

namespace App\Http\Controllers;

use App\Models\Docencia;
use App\Models\Professor;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class DocenciaController extends Controller
{
    public function index()
    {
        $data = Docencia::with('disciplina', 'professor') ->orderBy('disciplina_id')->get();
        $disciplinas = Disciplina::orderBy('nome')->get();

        return view('docencia.index', compact('data'));
    }

    
    public function create()
    {
        $disciplinas = Disciplina::orderBy('nome')->get();
        $professores = Professor::all();
        return view('docencia.create', compact('disciplinas', 'professores'));
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

        if ($request->validate($regras, $msgs)) {
            $disciplina_id = $request->input('disciplina_id');
            $disciplina = Disciplina::where('nome', $disciplina_id)->first();

            $professor_id = $request->input('professor');
            $professor = Professor::where('nome', $professor_id)->first();
    
            if ($disciplina && $professor) {
                $reg = new Docencia();
                $reg->disciplina_id = $disciplina->id;
                $reg->professor_id = $professor->id;

                $reg->save();
                return redirect()->route('docencia.index')->with('success', 'Docência cadastrada com sucesso');
            } else {
                return back()->with('error', 'Disciplina ou professor não encontrados');
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
        $dados = Docencia::find($id);
        $disciplinas = Disciplina::orderBy('nome')->get();
        $professores = Professor::all();

        if (!isset($dados)) { 
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('docencia.edit', compact('dados', 'disciplinas', 'professores'));     
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

        $reg = Docencia::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $disciplina = Disciplina::where('nome', $request->input('disciplina_id'))->first();
        $professor = Professor::where('nome', $request->input('professor_id'))->first();

        if ($disciplina) {
            $reg->disciplina_id = $disciplina->id;
            $reg->professor_id = $professor->id;

            $reg->save();

            return redirect()->route('docencia.index')->with('success', 'Docência atualizada com sucesso');
        } else {
            return back()->with('error', 'Disciplina ou professor não encontrados');
        }
    }

    
    public function destroy($id)
    {
        $docencia = Docencia::find($id);

        if (!$docencia) {
            return "<h1>ID: $id não encontrado!";
        }

        $docencia->delete();

        return redirect()->route('docencia.index');
    }
}