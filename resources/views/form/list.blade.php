<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            }

            tr:nth-child(even) {
            background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <h2>Busca</h2>
        <form action="{{url('/form/list')}}" method="get">
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
            <input type="submit" value="Buscar">
        </form>

        <h2>Usuários</h2>

        <table>
            <tr>
                <th>Id</th>
                <th>Nome completo</th>
                <th>Nome de login</th>
                <th>CEP</th>
                <th>Email</th>
            </tr>
            @foreach($list as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->user_name}}</td>
                    <td>{{$user->zip_code}}</td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
        </table>

    </body>
</html>

