@section('scripts')
	<script>
		$(document).ready(function() {
			fetch_users();
			function fetch_users() {
				$.ajax({
					type: "get",
					url: "{{ route('fetch_users') }}",
					dataType: "json",
					success: function(response) {
						$('tbody').html("");
						$.each(response.users, function (key, item) {
							$('#count').html('Количество записей: ' + response.count);
							var number = key +1;
							$('tbody').append('<tr>\
								<td>' + number + '</td>\
								<td>' + item.name + '</td>\
								<td>' + item.created_at+'</td>\
								<td>' + item.updated_at+'</td>\
								<td>' + item.id + '</td>\
								<td>\
									<div class="btn-group btn-group-sm d-flex justify-content-center">\
										<button class="btn btn-outline-danger" value="' + item.id + '" id="editbtn"><i class="fa fa-edit"></i></button>\
										<button class="btn btn-outline-danger" value="' + item.id + '" id="deletebtn"><i class="fa fa-trash"></i></button>\
									</div>\
								</td>\
							\</tr>');
						});
					}
				});
			}
			$('#addbtn').click(function() {
            		$('#id').val('');
           			$('#users_form').trigger("reset");
            		$('.modal-title').html("<i class='fa fa-plus pe-2'></i>Добавление пользователя");
            		$('#users_modal').modal('show');
       		});
			$(document).on('click', '#close_errors', function() {
            		$('#errors_message').removeClass();
           			$('#errors_message').html('');
        		});
			$('#save').click(function (e) {
            		e.preventDefault();
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
            		$.ajax({
					data: $('#users_form').serialize(),
					url: "{{ route('users.store') }}",
					type: "post",
					dataType: 'json',
					success: function (response) {
						if(response.status == 400) {
							$('#errors_message').html('');
							$('#errors_message').addClass('alert alert-danger text-center');
							$.each(response.errors, function(key, err_values) {
								$('#errors_message').append('<li class="list-group-numbered">'+ err_values + '</li>');
							})
						} else {
							fetch_users();
							$('#success_message').html('');
							$('#success_message').append('\
							<div class="alert alert-success alert-dismissible fade show text-center">\
								'+response.message+'\
								<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
							</div>'
							);
							$('#users_form').trigger("reset");
							$('#errors_message').removeClass();
							$('#errors_message').html('');
							$('#users_modal').modal('hide');
						}
                	},
            	});
       		});
			$(document).on('click', '#editbtn', function() {
				var id = $(this).val();
            		$.get("{{ route('users.store') }}" + '/' + id +'/edit', function (data) {
                			$('.modal-title').html("<i class='fa fa-edit pe-2'></i>Редактирование пользователя | ID:" + id);
                			$('#users_modal').modal('show');
                			$('#id').val(data.id);
                			$('#name').val(data.name);
            		})
       		});
			$(document).on('click', '#deletebtn', function () {
            		var id = $(this).val();
            		$('.modal-title').html("<i class='fa fa-trash pe-2'></i>Удаление пользователя | ID:"+id);
           			 $('#users_delete_modal').modal('show');
            		$('#id').val(id);
       		});
        		$(document).on('click', '#delete', function (e) {
            		e.preventDefault();
            		$.ajaxSetup({
                			headers: {
                    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               			}
            		});
            		var id = $('#id').val();
            		$.ajax({
					type: "delete",
					url: "{{ route('users.store') }}"+'/'+id,
					dataType: "json",
               			success: function (response) {
                    			if (response.status == 404) {
                        			fetch_users();
							$('#success_message').html("");
							$('#success_message').append('\
								<div class="alert alert-success alert-dismissible fade show text-center">\
									'+response.message+'\
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
								</div>'
							);
							$('#users_delete_modal').modal('hide');
                    			} else {
                        			fetch_users();
							$('#success_message').html("");
							$('#success_message').append('\
								<div class="alert alert-success alert-dismissible fade show text-center">\
									'+response.message+'\
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
								</div>'
							);
							$('#users_delete_modal').modal('hide');
                    			}
                			}
            		});
			});
		});
	</script>
@endsection