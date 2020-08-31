<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Teste Ahgora</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="py-5 text-center">
                <h2>Teste Ahgora!</h2>
                <h1>Termos mais utilizados</h1>
                <p>{{implode(', ', $termosUtilizados)}}</p>
                <h1>Total de {{$totalDiasFinal}} dias para Assistir!</h1>
            </div>
            <h3>Videos - Dia Assistindo</h3>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Dia</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Duração</th>
                    <th scope="col">Dia Assistido</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($diasAssistindo as $dia => $videos)
                        @foreach ($videos as $video)
                            <tr>
                                <th scope="row">{{$dia}}º</th>
                                <td>{{$video['titulo']}}</td>
                                <td>{{$video['duracao']}}</td>
                                <td>{{$video['diaAssistido']}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
