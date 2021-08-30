@extends('layouts.app')

@section('title', 'Направление')

@section('content')
	<div class="col-md-12">
		<div class="card">
			<div class="card-header d-flex justify-content-between">
				Список направлений
				<button type="button" class="btn btn-outline-danger" id="addbtn">
                    		<i class="fa fa-plus pe-2"></i>Добавить
                		</button>
			</div>
			<div class="card-body">
				<section id="success_message"></section>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="5%">№</th>
								<th width="40%">Наименование</th>
								<th width="20%">Дата добавления</th>
								<th width="20%">Дата редактирования</th>
								<th width="5%">ID</th>
								<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div id="count" class="text-end"></div>
			</div>
		</div>
	</div>
	@include('direction.modal') 
@endsection

@include('direction.ajax') 