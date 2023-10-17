<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use Illuminate\Http\Request;

class EixoController extends Controller
{
    
    public function index()
    {
        $data = Eixo::orderBy('nome')->get();
        return view('eixos.index', compact('data'));
    }

    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:50|min:10',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = new Eixo();
        $reg->nome = $request->nome;
        $reg->save();       
        
        return redirect()->route('eixos.index');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados = Eixo::find($id);

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('eixos.edit', compact('dados'));    
    }

    public function update(Request $request, $id) {
     
        $regras = [
            'nome' => 'required|max:50|min:4',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Eixo::find($id);
        
        if(isset($reg)) {
            $reg->nome = $request->nome;
            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('eixos.index');
    }

    
    public function destroy($id)
    {
        $reg=Eixo::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; } 
        
        else {

            $reg->destroy($id);
        }

        return redirect()->route('eixos.index');
    }
}
