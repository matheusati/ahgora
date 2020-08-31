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
	<body class="bg-light">
		<div class="container">
			<div class="py-5 text-center">
				<h2>Teste Ahgora!</h2>
			</div>
			<div class="row">
				<div class="col-md-8 order-md-4">
					<h4 class="mb-3">Pesquisar Videos</h4>
					<form action="{{route('busca')}}" method="GET">
						@csrf
						<div class="mb-3">
							<label for="parametro">Busca</label>
							<input type="text" class="form-control" id="parametro" placeholder="Digite Algo" name="parametro">
							<br>
							<label for="maximo">Limitador</label>
							<input type="number" id="maximo" name="maximo" min="1" max="50" step="1" value="15">
							<hr class="mb-4">
							<label for="div-input">Informar tempo em minutos por dia</label>
							<div class="input-group" id="div-input">
								<input type="number" class="form-control" name="tempo[]" value="15">
                				<input type="number" class="form-control" name="tempo[]" value="120">
                				<input type="number" class="form-control" name="tempo[]" value="30">
                				<input type="number" class="form-control" name="tempo[]" value="150">
                				<input type="number" class="form-control" name="tempo[]" value="20">
                				<input type="number" class="form-control" name="tempo[]" value="40">
                				<input type="number" class="form-control" name="tempo[]" value="90">
              				</div>
            			</div>
            			<hr class="mb-4">
            			<button class="btn btn-primary btn-lg btn-block" type="submit">Pesquisar/Calcular</button>
          			</form>
        		</div>
      		</div>
    	</div>
  </body>
</html>
