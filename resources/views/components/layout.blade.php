<!DOCTYPE html>
<html>
	<head>
		<title>Альбомы</title>
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	</head>
	<body style="background-color:gray">
	<div class="header">
        <h1 style="margin-left: 2%;margin-right: 1%;">Gallery</h1>
        <a href="{{route('main_page')}}" class="linkToPage">Главная</a>
        <a href="{{route('albums_main')}}" class="linkToPage">Альбомы</a>
        <!--<a href="" class="linkToPage">Семья</a>-->
        

		@if (isset($_SESSION["username"]))
			<a href="{{route('myaccount')}}" class="LoginPage">Личный кабинет</a>
			<a href="{{route('logoutPagePost')}}" class="linkToPage">Выйти</a>
		@else
			<a href="{{route('loginPage')}}" class="LoginPage">Войти</a>
			<a href="{{route('registrationPage')}}" class="linkToPage">Зарегистрироваться</a>
		@endif
    </div>
		{{ $slot }}
	</body >
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>

