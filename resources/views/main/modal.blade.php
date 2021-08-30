<div class="modal fade" id="directions_delete_modal">
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