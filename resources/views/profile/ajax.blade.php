@section('scripts')
	<script>
		$(document).ready(function() {
			fetch_profiles();
			function fetch_profiles() {
				$.ajax({
					type: "get",
					url: "{{ route('fetch_profiles') }}",
					dataType: "json",
					success: function(response) {
						$('#count').html('Количество записей: ' + response.count);
						$('tbody').html("");
						$.each(response.profiles, function (key, item) {
							var number = key + 1;
							$('tbody').append('<tr>\
								<td>'+number+'</td>\
								<td>' + item.name + '</td>\
								<td>' + item.faculty + '</td>\
								<td>' + item.directions_id  + '</td>\
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
           			$('#profiles_form').trigger("reset");
            		$('.modal-title').html("<i class='fa fa-plus pe-2'></i>Добавление профиля направления");
            		$('#profiles_modal').modal('show');
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
					data: $('#profiles_form').serialize(), 
					url: "{{ route('profiles.store') }}",
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
							fetch_profiles();
							$('#success_message').html('');
							$('#success_message').append('\
							<div class="alert alert-success alert-dismissible fade show text-center">\
								'+response.message+'\
								<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
							</div>'
							);
							$('#profiles_form').trigger("reset");
							$('#errors_message').removeClass();
							$('#errors_message').html('');
							$('#profiles_modal').modal('hide');
						}
                			},
            		});
       		});
			$(document).on('click', '#editbtn', function() {
				var id = $(this).val();
            		$.get("{{ route('profiles.store') }}" + '/' + id +'/edit', function (data) {
                			$('.modal-title').html("<i class='fa fa-edit pe-2'></i>Редактирование профиля направления | ID:" + id);
                			$('#profiles_modal').modal('show');
                			$('#id').val(data.id);
					$('#directions_id ').val(data.directions_id );
                			$('#name').val(data.name);
					$('#faculty').val(data.faculty);
            		})
       		});
			$(document).on('click', '#deletebtn', function () {
            		var id = $(this).val();
            		$('.modal-title').html("<i class='fa fa-trash pe-2'></i>Удаление профиля направления | ID:"+id);
           			 $('#profiles_delete_modal').modal('show');
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
					url: "{{ route('profiles.store') }}"+'/'+id,
					dataType: "json",
               			success: function (response) {
                    			if (response.status == 404) {
                        			fetch_profiles();
							$('#success_message').html("");
							$('#success_message').append('\
								<div class="alert alert-success alert-dismissible fade show text-center">\
									'+response.message+'\
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
								</div>'
							);
							$('#profiles_delete_modal').modal('hide');
                    			} else {
                        			fetch_profiles();
							$('#success_message').html("");
							$('#success_message').append('\
								<div class="alert alert-success alert-dismissible fade show text-center">\
									'+response.message+'\
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\
								</div>'
							);
							$('#profiles_delete_modal').modal('hide');
                    			}
                			}
            		});
			});
		});
	</script>
@endsection