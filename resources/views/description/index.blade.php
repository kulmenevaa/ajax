@extends('layouts.app')

@section('title', 'Описание')

@section('content')
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Реализовать интерфейс и базу данных для описанного ниже прототипа</div>
			<div class="row">
				<div class="col-md-10">
					<div class="card-body">
						<ol>
							<li>Левый блок - является каталогом</li>
							<li>Правый - корзиной</li>
						</ol>
						<h6>Каталог состоит из следующих элементов:</h6>
						<ul>
							<li>Родительский уровень - направления</li>
							<li>Дочерний уровень - профили</li>
							<li>Информация из левого блока остается неизменной и хранится в БД</li>
						</ul>
						<p class="m-0">Пользователь выбирает желаемые направления из каталога и добавляет в корзину.</p>
						<p class="m-0">Если в корзину добавляется направление, то принадлежащие ему профили тоже добавляются в корзину.</p>
						<p class="m-0">В корзине пользователь имеет возможность с помощью стрелок, менять порядковый номер (приоритет) направления и профилей в рамках своего направления.</p>
					</div>
				</div>
				<div class="col-md-2 border-start">
					<div class="card-body">
						<p class="text-center">
							Кнопка <q class="text-danger">очистить</q> <br>
							<i class="fa fa-arrow-down"></i><br>
							список очищается
						</p>
						<p class="text-center pt-3">
							Кнопка <q class="text-danger">сохранить</q><br>
							<i class="fa fa-arrow-down"></i><br>
							информация из корзины записывается в БД
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection