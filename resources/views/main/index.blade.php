@extends('layouts.app')

@section('title', 'Главная')

@section('content')
	<div class="col-md-12">
		<section id="success_message"></section>
		<section id="errors_message"></section>
	</div>
	<div class="col-md-6 mb-3">
		<div class="card">
			<div class="card-header text-center">Направления</div>
				@if($user)
					<span class="user_info">Пользователь: {{ $user->name }} | ID: {{ $user-> id }}</span>
				@endif
			<div class="card-body">
				<div class="table-responsive left-block mt-5"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 mb-3">
		<div class="card">
			<div class="card-header text-center">Выбранные направления</div>
			<div class="card-body">
				<div class="d-flex">
					<div class="w-100">
						<div class="d-flex justify-content-md-center justify-content-lg-end my_buttons">
							
						</div>
					</div>
				</div> 
				<div class="title"></div>
				<div class="table-responsive right-block mt-3"></div>
			</div>
		</div>
	</div>
	@include('main.modal') 
@endsection

@include('main.ajax') 