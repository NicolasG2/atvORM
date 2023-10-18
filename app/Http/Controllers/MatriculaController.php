<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Disciplina;
use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{

    public function index()
    {
        $data = Matricula::with('aluno', 'disciplina')->orderBy('aluno_id')->get();
        $alunos = Aluno::orderBy('nome')->get();

        return view('matricula.index', compact('data'));
    }


    public function create()
    {
        $alunos = Aluno::orderBy('nome')->get();
        $disciplinas = Disciplina::all();
        return view('matricula.create', compact('aluno', 'professores'));
    }


    public function store(Request $request)
    {
        $regras = [
            'aluno_id' => 'required',
            'disciplinas' => 'required|array',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "array" => "Selecione pelo menos uma disciplina.",
        ];

        $request->validate($regras, $msgs);

        $aluno = Aluno::find($request->input('aluno_id'));

        if (!$aluno) {
            return back()->with('error', 'Aluno não encontrado');
        }

        $disciplinasSelect = $request->input('disciplinas');

        foreach ($disciplinasSelect as $disciplinaId) {
            $disciplina = Disciplina::find($disciplinaId);
            if ($disciplina) {
                $matricula = new Matricula();
                $matricula->aluno_id = $aluno->id;
                $matricula->disciplina_id = $disciplina->id;
                $matricula->save();
            }
        }

        return redirect()->route('matricula.index')->with('success', 'Matrícula realizada com sucesso');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $dados = Matricula::find($id);
        $alunos = Aluno::orderBy('nome')->get();
        $disciplinas = Disciplina::all();
        if (!isset($dados)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('matricula.edit', compact('dados', 'alunos', 'disciplinas'));
    }


    public function update(Request $request, $id)
    {

        $regras = [
            'aluno_id' => 'required',
            'disciplina_id' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Matricula::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $aluno = Aluno::where('nome', $request->input('aluno_id'))->first();
        $disciplina = Disciplina::where('nome', $request->input('disciplina_id'))->first();

        if ($disciplina) {
            $reg->aluno_id = $aluno->id;
            $reg->disciplina_id = $disciplina->id;

            $reg->save();

            return redirect()->route('matricula.index')->with('success', 'Matrícula atualizada com sucesso');
        } else {
            return back()->with('error', 'Disciplina ou aluno não encontrados');
        }
    }


    public function destroy($id)
    {
        $matricula = Matricula::find($id);

        if (!$matricula) {
            return "<h1>ID: $id não encontrado!";
        }

        $matricula->delete();

        return redirect()->route('matricula.index');
    }
}