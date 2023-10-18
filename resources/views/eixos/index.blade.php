@extends('templates.main', ['titulo' => "Eixos e Áreas", 'rota' => "eixos.create"])
@section('titulo') Eixos e Áreas @endsection

@section('conteudo')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
    <div class="row">
        <div class="col">
            <table class="table align-middle caption-top table-striped">
                <caption>Tabela de <b>Eixos e Áreas</b></caption>
                <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-table-cell">ID</th>
                        <th scope="col">NOME</th>
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td d-none d-md-table-cell>{{ $item->id }}</td>
                            <td>{{ $item->nome }}</td>
                            <td>
                                <a href="{{ route('eixos.edit', $item->id) }}" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFF" class="bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                        <path
                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                    </svg>
                                </a>
                                <a href="{{ route('eixos.destroy', $item->id) }}"
                                    onclick="return confirm('Tem certeza de que deseja excluir este registro?')"
                                    class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFF"
                                        class="bi-trash-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z">
                                        </path>
                                    </svg>
                                </a>
                                
                            </td>
                            <form action="{{ route('eixos.destroy', $item->id) }}" method="POST"
                                id="form_{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@endsection
