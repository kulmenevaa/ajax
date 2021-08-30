<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
	<link href="/public/css/bootstrap.min.css" rel="stylesheet">
	<link href="/public/css/style.css" rel="stylesheet">
</head>
<body>
	<header class="p-3 border-bottom">
   		<div class="container">
     			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<ul class="nav col-12 col-lg-auto me-lg-auto mb-3 justify-content-center  mb-lg-0">
					<li class="nav-item"><a href="{{ route('main') }}" class="nav-link px-2 link-dark">Главная</a></li>
					<li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link px-2 link-dark">Пользователи</a></li>
					<li class="nav-item"><a href="{{ route('directions.index') }}" class="nav-link px-2 link-dark">Направление</a></li>
					<li class="nav-item"><a href="{{ route('profiles.index') }}" class="nav-link px-2 link-dark">Профиль направления</a></li>
					<li class="nav-item"><a href="{{ route('desc') }}" class="nav-link px-2 link-dark">Описание</a></li>
        		</ul>
				<form method="get" class="col-12 col-lg-auto mb-1 mb-lg-0 me-lg-3 search-user">
					<div class="input-group">
						<input type="search" name="s" id="s" class="form-control form-control-dark" value="{{ request()->s }}" placeholder="Введите ID пользователя">
						<div class="input-group-append">
							<button type="submit" class="btn btn-danger">Найти</button>
						</div>
					</div>
				</form>
      		</div>
    	</div>
  	</header>
	<main class="container">
		<div class="row">
			@yield('content')
		</div>
	</main>
	<footer>

	</footer>
</body>
<script src="{{ asset('/public/js/popper.min.js') }}"></script>
<script src="{{ asset('/public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/js/jquery.min.js') }}"></script>
<script src="{{ asset('/public/js/main.js') }}"></script>
@yield('scripts')
</html>