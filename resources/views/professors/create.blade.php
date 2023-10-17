<!-- Herda o layout padrão definido no template "main" -->
@extends('templates.main', ['titulo' => 'Novo Professor'])
<!-- Preenche o conteúdo da seção "titulo" -->
@section('titulo')
    Professor
@endsection
<!-- Preenche o conteúdo da seção "conteudo" -->
@section('conteudo')
    <form action="{{ route('professors.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="radio" id="ativo" name="ativo" value="0"
                        @if (old('ativo') == 0) checked @endif>
                    <label for="ativo">Ativo</label><br>
                </div>
                <div class="form-floating mb-3">
                    <input type="radio" id="inativo" name="ativo" value="1"
                        @if (old('ativo') == 1) checked @endif>
                    <label for="ativo">Inativo</label><br>
                </div>
                <div class='invalid-feedback'>
                    {{ $errors->first('ativo') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @if ($errors->has('nome')) is-invalid @endif"
                        name="nome" placeholder="Nome" value="{{ old('nome') }}" />
                    <label for="nome">Nome do Professor</label>
                    <div class='invalid-feedback'>
                        {{ $errors->first('nome') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif"
                        name="email" placeholder="E-mail" value="{{ old('email') }}" /> <label for="email">E-mail do
                        Professor</label>
                    <div class='invalid-feedback'>
                        {{ $errors->first('email') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control @if ($errors->has('siape')) is-invalid @endif"
                        name="siape" placeholder="Siape" value="{{ old('siape') }}" /> <label for="siape">Siape de
                        Professor</label>
                    <div class='invalid-feedback'>
                        {{ $errors->first('siape') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @if ($errors->has('eixo_id')) is-invalid @endif"
                        name="eixo_id" placeholder="Eixo/Área" list="eixo" value="{{ old('eixo_id') }}" />

                    <datalist id="eixo">
                        @foreach ($eixo_id as $eixo)
                            <option value="{{ $eixo->nome }}">
                        @endforeach
                    </datalist>
                    <label for="eixo_id">Eixo/Área</label>
                    <div class='invalid-feedback'>
                        {{ $errors->first('eixo_id') }}
                    </div>

                </div>
                <div class="row">
                    <div class="col">
                        <a href="{{ route('professors.index') }}" class="btn btn-secondary btn-block align-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z" />
                            </svg>
                            &nbsp; Voltar
                        </a>
                        <a href="javascript:document.querySelector('form').submit();"
                            class="btn btn-success btn-block align-content-center">
                            Confirmar &nbsp;
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                        </a>
                    </div>
                </div>
    </form>
@endsection
