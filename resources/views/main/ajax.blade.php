@section('scripts')
	<!-- left-block -->
	<script>
		$(document).ready(function() {
			fetch_left_block();
			fetch_right_block_by_user();
			var arr_directions = []; 
			var new_arr_directions = [];
			/* Модельное окно - удаление записи */
			$(document).on('click', '#deletebtn', function () {
				var id = $(this).val();
				$('.modal-title').html("<i class='fa fa-trash pe-2'></i>Удаление направления | ID:"+id);
				$('#directions_delete_modal').modal('show');
				$('#id').val(id);
       		});
			/* Удаление направления с профилями */
        	$(document).on('click', '#delete', function (e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var id = $('#id').val();
				$.ajax({
					type: "delete",
					url: "{{ route('directions.store') }}"+'/'+id,
					dataType: "json",
					success: function (response) {
                    	if (response.status == 404) {
							alert(response.message);
							$('#directions_delete_modal').modal('hide');
                    	} else {
							alert(response.message);
							$('#directions_delete_modal').modal('hide');
                    	}
						fetch_left_block();
                	}
            	});
			});
			/* Очистка */
			$(document).on('click', '#clear_guest', function (e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				arr_directions = [];
				new_arr_directions = [];
				$('#success_message').html('');
				$('.right-block').empty();
			});
			$(document).on('click', '#clear_user', function (e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var user = {!! json_encode($user) !!};
				if(user) {
					$('#success_message').html('');
					$('.right-block').empty();
					$.ajax({
						data: {user:user},
						url: "{{ route('clear') }}",
						dataType: "json",
						success: function(response) {
							alert(response.message);
						}
					});
				} else {
					alert('Пользователь не идентифицирован!');
				}
			});
			/* Удаление */
			$(document).on('click', '#delete_cart_guest', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var id = $(this).val();
				$('#success_message').html('');
				$.ajax({
					type: "get",
					url: "{{ route('fetch_right_block') }}"+'/'+id,
					dataType: "json",
					success: function (response) {
						if(response.id == id) {
							arr_directions.forEach(function(response, i) {
								if (response.id == id) {
									arr_directions.splice(i, 1);
								}
							});
							fetch_right_block();
						}
					}
				});
			});
			$(document).on('click', '#delete_cart_user', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var id = $(this).val();
				var user = {!! json_encode($user) !!};
				$('#success_message').html('');
				if(user) {
					$.ajax({
						data: {user:user, id:id},
						type: "get",
						url: "{{ route('delete_cart_user') }}",
						dataType: "json",
						success: function (response) {
							alert(response.message);
							fetch_right_block_by_user();
						}
					});
				} else {
					alert('Пользователь не идентифицирован!');
				}
			});
			$(document).on('click', '#up_directions_guest, #down_directions_guest', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        			var row = $(this).parents("table");
				if($(this).is('#up_directions_guest')){
					var oldrownumber = row.index();
					row.insertBefore(row.prev());
					var rownumber = row.index();
					rownumber = rownumber;
				} else {
					var oldrownumber = row.index();
					row.insertAfter(row.next());
					var rownumber = row.index();
					rownumber = rownumber;	
				}
				var swaped = array_move(arr_directions, oldrownumber, rownumber); 
			});
			$(document).on('click', '#up_profiles_guest, #down_profiles_guest', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        		var row = $(this).parents("tr");
				if($(this).is('#up_profiles_guest')){
					var oldrownumber = row.index();
					row.insertBefore(row.prev());
					var rownumber = row.index();
					rownumber = rownumber;
				} else {
					var oldrownumber = row.index();
					row.insertAfter(row.next());
					var rownumber = row.index();
					rownumber = rownumber;	
				}
				$.each(arr_directions, function(key, item_directions) {
					array_move(item_directions.profile, oldrownumber, rownumber); 
				});
			});

			$(document).on('click', '#up_directions_user, #down_directions_user', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var user = {!! json_encode($user) !!};
				if(user) {
					var row = $(this).parents("table");
					if($(this).is('#up_directions_user')){
						var oldrownumber = row.index();
						row.insertBefore(row.prev());
						var rownumber = row.index();
						rownumber = rownumber;
					} else {
						var oldrownumber = row.index();
						row.insertAfter(row.next());
						var rownumber = row.index();
						rownumber = rownumber;	
					}
					var swaped = array_move(new_arr_directions, oldrownumber, rownumber); 
					/* console.log(new_arr_directions); */
				}
			});
			$(document).on('click', '#up_profiles_user, #down_profiles_user', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var user = {!! json_encode($user) !!};
				if(user) {
					var row = $(this).parents("tr");
					if($(this).is('#up_profiles_user')){
						var oldrownumber = row.index();
						row.insertBefore(row.prev());
						var rownumber = row.index();
						rownumber = rownumber;
					} else {
						var oldrownumber = row.index();
						row.insertAfter(row.next());
						var rownumber = row.index();
						rownumber = rownumber;	
					}
					$.each(new_arr_directions, function(key, item_directions) {
						array_move(item_directions.profile, oldrownumber, rownumber); 
					});
					/* console.log(new_arr_directions); */
				}
			});
			/* Левый блок */
			function fetch_left_block() {
				$.ajax({
					type: "get",
					url: "{{ route('fetch_left_block') }}",
					dataType: "json",
					success: function(response) {
						$('.left-block').html("");
						$.each(response.directions, function (key, item_directions) {
							var number = key + 1;
							var content = '<table class="table table-bordered">\
								<thead>\
									<tr>\
										<th width="5%">'+ number +'</th>\
										<th width="85%">\
											<div>'+ item_directions.name + '</div>\
										</th>\
										<th width="10%">\
											<div class="d-flex justify-content-end">\
												<button class="btn px-2"  value="' + item_directions.id + '" id="addbtn" title="Добавить"><i class="fa fa-plus fa-sm"></i></button>\
												<button class="btn px-2"  value="' + item_directions.id + '" id="deletebtn" title="Удалить"><i class="fa fa-times fa-sm"></i></button>\
											</div>\
										</th>\
									</tr>\
								</thead>\
								<tbody>\
							';
							$.each(item_directions.profile, function (key, item_profiles) {
								content += '\
									<tr>\
										<td colspan="3">\
											<div class="d-flex justify-content-between">\
												'+ item_profiles.name + '<span class="badge m-w-50">'+ item_profiles.faculty +'</span>\
											</div>\
										</td>\
									</tr>\
								';
							}); 
							content += '</tbody></table>';
							$('.left-block').append(content);
						});
					}
				});
			}
			/* Правый блок */
			function fetch_right_block() {
				$('.my_buttons').html('');
				$('.my_buttons').append('\
					<button type="button" class="btn btn-outline-danger btn-sm me-1" id="clear_guest">Очистить</button>\
					<button type="button" class="btn btn-outline-danger btn-sm ms-1" id="save_guest">Сохранить</button>\
				');
				$('.title').html('');
				$('.title').append('<h4 class="text-center">Предварительный просмотр</h4>');
				$('.right-block').html('');
				$.each(arr_directions, function (key, item_directions) {
					var content = '<table class="table table-bordered">\
						<thead>\
							<tr>\
								<th width="5%">'+ (key+1) +'</th>\
								<th width="85%">\
									<div>'+ item_directions.name + '</div>\
								</th>\
								<th width="10%">\
									<div class="d-flex justify-content-end">\
										<button class="btn px-2 up" value="'+(key+1)+'" id="up_directions_guest" title="Вверх" data-icon="&#9650;"></button>\
										<button class="btn px-2 down" value="'+(key+1)+'" id="down_directions_guest" title="Вниз" data-icon="&#9660;"></button>\
										<button class="btn px-2" value="'+item_directions.id+'" id="delete_cart_guest" title="Удалить"><i class="fa fa-times fa-sm"></i></button>\
									</div>\
								</th>\
							</tr>\
						</thead>\
						<tbody>\
					';
					$.each(item_directions.profile, function (key, item_profiles) {
						content += '\
							<tr>\
								<td class="p-0">\
									<div class="d-flex justify-content-between">\
										<button class="btn px-1 up" value="'+item_profiles.id+'" id="up_profiles_guest" title="Вверх" data-icon="&#9650;"></button>\
										<button class="btn px-1 down" value="'+item_profiles.id+'" id="down_profiles_guest" title="Вниз" data-icon="&#9660;"></button>\
									</div>\
								</td>\
								<td colspan="2">\
									<div class="d-flex justify-content-between">\
										'+ item_profiles.name + '<span class="badge m-w-50">'+ item_profiles.faculty +'</span>\
									</div>\
								</td>\
							</tr>\
						';
					}); 
					content += '</tbody></table>';
					$('.right-block').append(content);
				});
			}
			/* Правый блок для пользователя */
			function fetch_right_block_by_user() {
				$('.title').html('');
				var user = {!! json_encode($user) !!};
				$('.my_buttons').html('');
				$('.my_buttons').append('\
					<button type="button" class="btn btn-outline-danger btn-sm me-1" id="clear_user">Очистить</button>\
					<button type="button" class="btn btn-outline-danger btn-sm ms-1" id="save_user">Сохранить</button>\
				');
				if(user) {
					$.ajax({
						data: {user:user},
						url: "{{ route('fetch_right_block_by_user') }}",
						dataType: "json",
						success: function(response) {
							$('.right-block').html('');
							$.each(response.directions, function(key, item_directions) {
								var content = '<table class="table table-bordered">\
									<thead>\
										<tr>\
											<th width="5%">'+ (key+1) +'</th>\
											<th width="85%">\
												<div>'+ item_directions.name + '</div>\
											</th>\
											<th width="10%">\
												<div class="d-flex justify-content-end">\
													<button class="btn px-2 up" value="'+(key+1)+'" id="up_directions_user" title="Вверх" data-icon="&#9650;"></button>\
													<button class="btn px-2 down" value="'+(key+1)+'" id="down_directions_user" title="Вниз" data-icon="&#9660;"></button>\
													<button class="btn px-2" value="'+item_directions.id+'" id="delete_cart_user" title="Удалить"><i class="fa fa-times fa-sm"></i></button>\
												</div>\
											</th>\
										</tr>\
									</thead>\
									<tbody>\
								';
								$.each(item_directions.profile, function (key, item_profiles) {
									content += '\
										<tr>\
											<td class="p-0">\
												<div class="d-flex justify-content-between">\
													<button class="btn px-1 up" value="'+item_profiles.id+'" id="up_profiles_user" title="Вверх" data-icon="&#9650;"></button>\
													<button class="btn px-1 down" value="'+item_profiles.id+'" id="down_profiles_user" title="Вниз" data-icon="&#9660;"></button>\
												</div>\
											</td>\
											<td colspan="2">\
												<div class="d-flex justify-content-between">\
													'+ item_profiles.name + '<span class="badge m-w-50">'+ item_profiles.faculty +'</span>\
												</div>\
											</td>\
										</tr>\
									';
								});   
								content += '</tbody></table>';
								$('.right-block').append(content);
							});
							new_arr_directions = response.directions;
						}
					})
				}
			}
			/* Перемещение элемента в массиве */
			function array_move(arr, old_index, new_index) {
				if (new_index >= arr.length) {
					var k = new_index - arr.length + 1;
					while (k--) {
						arr.push(undefined);
					}
				}
				arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
				return arr; 
			};
			/*************************************************************************************************************************************/
			/*************************************************************************************************************************************/
			/*************************************************************************************************************************************/

			/* Сохранение */
			$(document).on('click', '#save_guest', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var user = {!! json_encode($user) !!};
				if(user) {
					$.ajax({
						data: { user:user, arr_directions:arr_directions },
						type: "get",
						url: "{{ route('save_right_block') }}",
						dataType: "json",
						success: function (response) {
							if(response.status == 200) {
								alert(response.message);
								arr_directions = [];
								fetch_right_block_by_user();
							}
						}
					});
				} else {
					alert('Пользователь не идентифицирован!');
				}
			});
			$(document).on('click', '#save_user', function(e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var user = {!! json_encode($user) !!};
				if(user) {
					$.ajax({
						data: { user:user, new_arr_directions:new_arr_directions },
						type: "get",
						url: "{{ route('save_right_block_by_user') }}",
						dataType: "json",
						success: function (response) {
							alert(response.message);
							fetch_right_block_by_user();
						}
					});
				} else {
					alert('Пользователь не идентифицирован!');
				}
			});
			/* Добавление */
			$(document).on('click', '#addbtn', function (e) {
				e.preventDefault();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				var id = $(this).val();
				var user = {!! json_encode($user) !!};
				if(user) {
					$.ajax({
						type: "get",
						url: "{{ route('fetch_right_block') }}"+'/'+id,
						dataType: "json",
						success: function (response) {
							arr_directions.push(response);
							var json_string = arr_directions.map(JSON.stringify);
							var set = new Set(json_string);
							var array = Array.from(set);
							arr_directions = array.map(JSON.parse);
							fetch_right_block();		
						}
					});
				} else {
					alert('Пользователь не идентифицирован!');
				}
			});
		});
	</script>
@endsection