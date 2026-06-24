<div>
    <form action="{{ route('aluno.add') }}" method="post">
        @csrf
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome">

        <button type="submit">Salvar</button>
        @isset($success)
            <h1>{{ $success }}</h1>
        @endisset
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </form>

    @isset($alunos)
            @foreach($alunos as $aluno)
                <h3>{{ $aluno->nome }}</h3>
            @endforeach
    @endisset
</div>
