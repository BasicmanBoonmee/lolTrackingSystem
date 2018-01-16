@extends('layout')

@section('css')
	<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<style>
		.box-add-ajax{
			display: none;
		}
	</style>
@stop

@section('content')
	<div class="row">
		<div class="col s6 m6 l6">
			<div class="card">
				<div class="card-content">
					<form action="{{ route('client.update') }}" method="post">
						<div class="row">
							<div class="col s4">
								<span class="card-title">Edit Client</span>
							</div>
							<div class="col s8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<input type="hidden" name="id" value="{{ $client->id }}" />
								<input type="submit" value="Save" class="waves-effect waves-light btn right" />
								<a href="{{ route('client.index') }}" class="waves-effect waves-light btn red right">
									Cancel
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<div class="row">
									<div class="input-field col s12">
										<input id="name" name="name" type="text" value="{{ $client->name }}" class="validate">
										<label for="name">Name</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<input id="email" name="email" type="email" value="{{ $client->email }}" class="validate">
										<label for="email">Email</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<input id="phone" type="text" name="phone" value="{{ $client->phone }}" >
										<label for="phone">Phone number</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<input id="code" name="code" type="text" value="{{ $client->code }}" >
										<label for="code">Code</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<input id="payment_term" name="payment_term" value="{{ $client->payment_term }}" type="number" >
										<label for="payment_term">Payment Term</label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col s6 m6 l6">
			<div class="card">
				<div class="card-content">
					<div class="row">
						<div class="col s4">
							<span class="card-title">Rate</span>
						</div>
						<div class="col s8">
							<input type="button" value="Add" onClick="addRate();" class="waves-effect waves-light btn right" />
						</div>

						<div class="col s12 box-add-ajax">
							<div class="input-field col s12">
								<select id="type_rate_id" name="type_rate_id">
									<option value="0">- Select -</option>
									@foreach($typerate as $value)
										<option value="{{ $value->id }}">{{ $value->name }}</option>
									@endforeach
								</select>
								<label for="type_rate_id">Rate</label>
							</div>

							<div class="input-field col s12">
								<input id="price" name="price" type="text" value="" >
								<label id="label_price" for="price" class="active">Price</label>
							</div>

							<div class="input-field col s12">
								<input id="currency" name="currency" type="text" value="" >
								<label id="label_currency" for="currency" class="active">Currency</label>
							</div>

							<input type="hidden" id="client_rate_id" value="0" />
							<input type="button" value="Save" onClick="saveAjax();" class="waves-effect waves-light btn right" />
							<input type="button" onClick="cancelRate();" value="Cancel" class="waves-effect waves-light btn red right" />

						</div>

						<div class="col s12">
							<table id="dataTable" class="display responsive-table datatable-example">
								<thead>
								<tr>
									<th>Rate</th>
									<th>Price</th>
									<th></th>
								</tr>
								</thead>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
@stop


@section('js')
	<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>

	<script>
        var dataTable = $('#dataTable').DataTable( {
            "processing": true,
            "serverSide": true,
            paging: false,
			searching: false,
            "ajax": {
                "url" : "{{ route('client.rateajax') }}",
                "type" : "POST",
                "dataType": "jsonp",
                "data" : {
                    "_token" : "{{ csrf_token() }}",
					"client_id" : "{{ $client->id }}"
                }
            },
            "columns": [
                { "data": "rate" },
                { "data": "price" },
                { "data": "actions" }
            ]
        } );

        function addRate(){
            $("#client_rate_id").val(0);
            $("#type_rate_id").val("");
            $("#price").val("");
            $("#currency").val("");
            $('#dataTable_wrapper').hide();
            $('.box-add-ajax').show();
		}

		function cancelRate(){
            $('.box-add-ajax').hide();
            $('#dataTable_wrapper').show();
		}

		function editRate(id){
			$.ajax({
				url: '{{ route('client.getrate') }}',
                type:'POST',
                dataType: 'jsonp',
                data:{
                    "_token" : "{{ csrf_token() }}",
                    "id" : id
                },
				success: function(data){
                    $("#client_rate_id").val(id);
                    $("#type_rate_id").val(data.rate);
                    $("#price").val(data.price);
                    $("#currency").val(data.currency);
                    $("#label_price").addClass('active');
                    $("#label_currency").addClass('active');
                    $('#dataTable_wrapper').hide();
                    $('.box-add-ajax').show();
				}
			});
		}

        function saveAjax(){
            $.ajax({
				url:'{{ route('client.saveajax') }}',
				type:'POST',
				dataType: 'jsonp',
				data:{
                    "_token" : "{{ csrf_token() }}",
					"id" : $("#client_rate_id").val(),
                    "client_id" : "{{ $client->id }}",
                    "type_rate_id" : $("#type_rate_id").val(),
                    "price" : $("#price").val(),
                    "currency" : $("#currency").val()
				},
				success:function(data){
				    if(data.success == 1){
                        cancelRate();
                        dataTable.ajax.reload();
					}
				}
			});
		}

		function deleteRate(id){
            $.ajax({
                url:'{{ route('client.deleterate') }}',
                type:'POST',
                dataType: 'jsonp',
                data:{
                    "_token" : "{{ csrf_token() }}",
                    "id" : id,
                },
                success:function(data){
                    if(data.success == 1){
                        dataTable.ajax.reload();
                    }
                }
			});
		}

	</script>

@stop