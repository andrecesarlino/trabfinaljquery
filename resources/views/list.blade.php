<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Tarefa</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>
<body>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">

				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title"><i class="fa fa-tasks" aria-hidden="true"></i>
					 Lista de tarefas <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal">
					 <i class="fa fa-plus-square" aria-hidden="true"></i></a></h3>
				  </div>



				  <div class="panel-body" >
				    <ul class="list-group" id="items">
					@foreach($items as $item)
					   	<li class="list-group-item list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{ $item->item }} <input type="hidden" id="itemId" value="{{ $item->id }}"></li>
						   
					@endforeach
				    </ul>
				  </div>


				  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							  </button>
							</div>
							<div class="modal-body">
								<label>Tarefa</label>
								<input type="hidden" id="id">
								<p><input type="text" id="addItem" placeholder="Adicione a tarefa" class="form-control"></p>
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal" id= "delete" style="display: none;">Deletar</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="saveChanges" style="display: none;">Salvar</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="addButton">Add</button>
							</div>
						  </div>
						</div>
					  </div>
			</div>
		</div>
	</div>

	{{ csrf_field() }}

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script >
		$(document).ready(function() {

			$(document).on('click', '.ourItem', function() {
				var text = $(this).text();
				var text = $.trim(text);
				var id = $(this).find('#itemId').val();
				$("#addItem").val(text); 
				$('#title').text("Edit Item");
				$('#delete').show();
				$('#saveChanges').show();
				$('#addButton').hide();
				$('#id').val(id);
				console.log(text);
			});

			$(document).on('click' , '#addNew', function(event) {
				$('#title').text("Add New Item");
				$('#delete').hide();
				$('#saveChanges').hide();
				$('#addButton').show();
				$('#addItem').val("");
			});

			$('#addButton').click(function(event) {
				var text = $('#addItem').val();
				if(text == "") {
					alert("Digite um nome")
				} else {
					$.post('list', {'field' : text, '_token' : $('input[name=_token]').val() }, function(data)
					{
						console.log(data);
						$('#items').load(location.href + ' #items');
					});

				}
			});

			$('#delete').click(function(event) {
				var id = $('#id').val();
				$.post('delete', {'field' : id, '_token' : $('input[name=_token]').val() }, function(data)
				{
					$('#items').load(location.href + ' #items');
					/*console.log(data);*/
				});
			});

			$('#saveChanges').click(function(event) {
				var id = $('#id').val();
				var value = $('#addItem').val();
				if (value == "") {
					alert("Digite um nome")
				} else {
					$.post('update', {'id' : id,'value' : value, '_token' : $('input[name=_token]').val() }, function(data)
					{
						$('#items').load(location.href + ' #items');
					});
				}
			});
		});
	</script>
</body>
</html>