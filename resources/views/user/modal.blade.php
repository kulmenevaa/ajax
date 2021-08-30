<div class="modal fade" id="users_modal">
    	<div class="modal-dialog modal-dialog-centered">
        	<div class="modal-content">
            	<div class="modal-header">
                		<h5 class="modal-title"></h5>
                		<button type="button" class="btn-close" data-bs-dismiss="modal" id="close_errors"></button>
           		</div>
			<form id="users_form" name="users_form">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<ul id="errors_message"></ul>
					<div class="form-floating my-2">
						<input type="text" id="name" name="name" class="form-control" placeholder="Наименование">
						<label for="name">Наименование</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="close_errors">Отмена</button>
					<button type="button" class="btn btn-primary" id="save">Сохранить</button>
				</div>
			</form>
        	</div>
    	</div>
</div>

<div class="modal fade" id="users_delete_modal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title"></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
			</div>
			<div class="modal-body">
			<input type="hidden" id="id" name="id">
			<h5>Вы действительно хотите удалить эту запись?</h5>
			<p class="text-muted m-0">
				<span class="text-danger">*</span>
				Удаление записи происходит безвозвратно! Без возможности отката операции
			</p>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
			<button type="button" class="btn btn-primary" id="delete">Удалить</button>
			</div>
		</div>
	</div>
</div>