@section('scripts')
	<script>
		$(document).ready(function() {
			fetch_directions();
			function fetch_directions() {
				$.ajax({
					type: "get",
					url: "{{ route('fetch_directions') }}",
					dataType: "json",
					success: function(response) {
						$('#count').html('Количество записей: ' + response.count);
						$('tbody').html("");
						$.each(response.directions, function (key, item) {
							var number = key + 1;
							$('tbody').append('<tr>\
								<td>'+number+'</td>\
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
           			$('#directions_form').trigger("reset");
            		$('.modal-title').html("<i class='fa fa-plus pe-2'></i>Добавление направления");
            		$('#directions_modal').modal('show');
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
					data: $('#directions_form').serialize(),
					url: "{{ route('directions.store') }}",
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
							fetch_directions();
							$('#success_message').html('');
							$('#success_message').append('\
							<div class="alert alert-success alert-dismissible fade show text-center">\
								'+response.message+'\
								<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
							</div>'
							);
							$('#directions_form').trigger("reset");
							$('#errors_message').removeClass();
							$('#errors_message').html('');
							$('#directions_modal').modal('hide');
						}
                			},
            		});
       		});
			$(document).on('click', '#editbtn', function() {
				var id = $(this).val();
            		$.get("{{ route('directions.store') }}" + '/' + id +'/edit', function (data) {
                			$('.modal-title').html("<i class='fa fa-edit pe-2'></i>Редактирование направления | ID:" + id);
                			$('#directions_modal').modal('show');
                			$('#id').val(data.id);
                			$('#name').val(data.name);
            		})
       		});
			$(document).on('click', '#deletebtn', function () {
            		var id = $(this).val();
            		$('.modal-title').html("<i class='fa fa-trash pe-2'></i>Удаление направления | ID:"+id);
           			 $('#directions_delete_modal').modal('show');
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
					url: "{{ route('directions.store') }}"+'/'+id,
					dataType: "json",
               			success: function (response) {
                    			if (response.status == 404) {
                        			fetch_directions();
							$('#success_message').html("");
							$('#success_message').append('\
								<div class="alert alert-success alert-dismissible fade show text-center">\
									'+response.message+'\
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
								</div>'
							);
							$('#directions_delete_modal').modal('hide');
                    			} else {
                        			fetch_directions();
							$('#success_message').html("");
							$('#success_message').append('\
								<div class="alert alert-success alert-dismissible fade show text-center">\
									'+response.message+'\
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
								</div>'
							);
							$('#directions_delete_modal').modal('hide');
                    			}
                			}
            		});
			});
		});
	</script>
@endsection