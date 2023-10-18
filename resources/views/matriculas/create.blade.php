@extends('templates.main', ['titulo' => 'Nova Matrícula'])

@section('titulo')
    Matrícula
@endsection

@section('conteudo')
    <form action="{{ route('matricula.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="aluno_id">Aluno</label>
                    <select class="form-control @if ($errors->has('aluno_id')) is-invalid @endif"
                            name="aluno_id" id="aluno_id">
                        <option value="">Selecione um aluno</option>
                        @foreach ($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('aluno_id') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Disciplinas</label>
                    @foreach ($disciplinas as $disciplina)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="disciplinas[]" value="{{ $disciplina->id }}">
                            <label class="form-check-label">{{ $disciplina->nome }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-success">Confirmar</button>
            </div>
        </div>
    </form>
@endsection
