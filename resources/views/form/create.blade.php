@if ($errors->any())
    <h3 style='color:red'>Errors</h3>
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li style='color:red' >{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (@$id)
    <h3 style='color:blue'>Inserção realizada com sucesso, id {{$id}}!!</h3>
@endif
<form action="{{url('/form')}}" method="post">
    @csrf
    <div>
        <label for="name">Nome completo:</label>
        <input type="text" id="name" name="name">
    </div>
    <div>
        <label for="userName">Nome de login:</label>
        <input type="text" id="userName" name="userName">
    </div>
    <div>
        <label for="zipCode">CEP</label>
        <input type="text" id="zipCode" name="zipCode">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
    </div>
    <div>
        <label for="password">Senha (8 caracteres mínimo, contendo pelo menos 1 letra
        e 1 número):</label>
        <input type="password" id="password" name="password">
    </div>
    <input type="submit" value="Cadastrar">
</form>