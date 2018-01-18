@extends('layout')

@section('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

	<style>
		.select2-container{
			width: 100% !important;
		}

		/*.select-wrapper input.select-dropdown{
			display:none;
		}*/
	</style>

@stop

@section('content')
	<div class="row">
		<div class="col s6 m6 l6">
			<div class="card">
				<div class="card-content">
					<form action="{{ route('project.update') }}" method="post">
						<div class="row">
							<div class="col s4">
								<span class="card-title">Edit Project</span>
							</div>
							<div class="col s8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<input type="hidden" name="id" value="{{ $project->id }}" />
								<input type="submit" value="Save" class="waves-effect waves-light btn right" />
								<a href="{{ route('project.index') }}" class="waves-effect waves-light btn red right">
									Cancel
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<div class="row">
									<div class="input-field col s12">
										<input id="name" name="name" type="text" value="{{ $project->name }}" class="validate">
										<label for="name" class="active">Name</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<select id="status" name="status">
											<option>- Select -</option>
											<option value="In Progress" @if($project->status == "In Progress"){{ "selected" }}@endif>In Progress</option>
											<option value="Delivered" @if($project->status == "Delivered"){{ "selected" }}@endif>Delivered</option>
											<option value="Closed" @if($project->status == "Closed"){{ "selected" }}@endif>Closed</option>
											<option value="Cancelled" @if($project->status == "Cancelled"){{ "selected" }}@endif>Cancelled</option>
											<option value="Pending" @if($project->status == "Pending"){{ "selected" }}@endif>Pending</option>
											<option value="Headsup" @if($project->status == "Headsup"){{ "selected" }}@endif>Headsup</option>
											<option value="On hold" @if($project->status == "On hold"){{ "selected" }}@endif>On hold</option>
											<option value="Sent to Invoice" @if($project->status == "Sent to Invoice"){{ "selected" }}@endif>Sent to Invoice</option>
										</select>
										<label for="status" class="active">Status</label>
									</div>
								</div>


								<div class="row">
									<div class="input-field col s12">
										<select id="type_rate" name="type_rate">
											<option>- Select -</option>
											@foreach($typerate as $value)
												<option @if($project->type_rateFK == $value->id){{ "selected" }}@endif value="{{ $value->id }}">{{ $value->name }}</option>
											@endforeach
										</select>
										<label for="type_rate" class="active">Type</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<input type="hidden" id="rate_price" />
										<input type="hidden" name="client" id="client" value="{{ $project->clientsFK }}" />
										<select id="select_client" class="select2 js-states browser-default" tabindex="-1"></select>
										<label for="select_client" class="active">Client</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<input id="unit_total" onkeyup="calPrice(this.value);" type="number" name="unit_total" value="{{ $project->unit_total }}" >
										<label for="unit_total" class="active">WC / Hourly</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<input id="total_price" type="number" name="total_price" value="{{ $project->total_price }}" >
										<label for="total_price" class="active">Client fee</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="start_date" class="active">Start Project</label>
										<input id="start_date" type="text" name="start_date" class="datepicker" value="{{ date("d/m/Y",strtotime($project->start_date)) }}" >
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="dead_line" class="active">Client Deadline</label>
										<input id="dead_line" type="text" name="dead_line" class="datepicker" value="{{ date("d/m/Y",strtotime($project->dead_line)) }}" >
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="end_date" class="active">Delivery Project</label>
										<input id="end_date" type="text" name="end_date" class="datepicker" value="{{ date("d/m/Y",strtotime($project->end_date)) }}" >
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
							<span class="card-title">Linguist</span>
						</div>
						<div class="col s8" id="add-form-btn">
							<input type="button" value="Add" onClick="addForm();" class="waves-effect waves-light btn right" />
						</div>

						<div class="col s12 box-add-ajax" style="display:none;">
							<div class="input-field col s12">
								<select id="lg_status" name="lg_status">
									<option value="">- Select -</option>
									<option value="In Progress">In Progress</option>
									<option value="Finished">Finished</option>
									<option value="Closed">Closed</option>
									<option value="Headsup">Headsup</option>
								</select>
								<label for="lg_status">Status</label>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input type="hidden" id="rate_word" />
									<input type="hidden" id="rate_hourly" />
									<input type="hidden" name="linguist" id="linguist" value="" />
									<select id="select_linguist" class="select2_lg js-states browser-default" tabindex="-1"></select>
									<label for="select_linguist" class="active">Linguist</label>
								</div>
							</div>

							<div class="input-field col s6">
								<input id="wc" name="wc" onkeyup="calPriceLg();" type="number" value="" placeholder="0" >
								<label for="wc" class="active">WC</label>
							</div>

							<div class="input-field col s6">
								<input id="hourly" name="hourly" onkeyup="calPriceLg();" type="number" value="" placeholder="0" >
								<label for="hourly" class="active">Hourly</label>
							</div>

							<div class="input-field col s6">
								<input id="price" name="price" type="text" value="" placeholder="0" >
								<label id="label_price" for="price" class="active">Price</label>
							</div>

							<div class="input-field col s6">
								<input id="currency" name="currency" type="text" value="" >
								<label id="label_currency" for="currency" class="active">Currency</label>
							</div>

							<div class="input-field col s6">
								<input id="score" name="score" type="text" value="" placeholder="0" >
								<label id="label_score" for="score" class="active">Score</label>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<select id="late" >
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
									<label for="late">Late?</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<textarea id="note" name="note" class="materialize-textarea"></textarea>
									<label for="note" id="label_note">Note</label>
								</div>
							</div>

							<input type="hidden" id="project_lg_id" value="0" />
							<input type="button" value="Save" onClick="saveAjax();" class="waves-effect waves-light btn right" />
							<input type="button" onClick="cancelForm();" value="Cancel" class="waves-effect waves-light btn red right" />

						</div>

						<div class="col s12">
							<table id="dataTable" class="display responsive-table datatable-example">
								<thead>
								<tr>
									<th>Linguist</th>
									<th>Status</th>
									<th>Price</th>
									<th>Late?</th>
									<th></th>
								</tr>
								</thead>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>


		<div class="col s6 m6 l6">
			<div class="card">
				<div class="card-content">
					<div class="row">
						<div class="col s12">
							<span class="card-title">Payment</span>
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<label for="invoice_date" class="active">Invoiced Date</label>
							<input id="invoice_date" type="text" name="invoice_date" class="datepicker" value="{{ date("d/m/Y",strtotime($project->start_date)) }}" >
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<label for="expected_date" class="active">Expected Date</label>
							<input id="expected_date" type="text" name="expected_date" class="datepicker" value="{{ date("d/m/Y",strtotime($project->start_date)) }}" >
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<label for="received_date" class="active">Received Date</label>
							<input id="received_date" type="text" name="received_date" class="datepicker" value="{{ date("d/m/Y",strtotime($project->start_date)) }}" >
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

@stop

@section('js')

    <script src="{{ asset('assets/plugins/select2/js/select2.js') }}"></script>
	<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>

	<script>

        var dataTable;

        $(document).ready(function() {
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: 15,
                closeOnSelect: true,
                format: 'dd/mm/yyyy',
            });

            $('.select2').select2({
                ajax: {
                    url: '{{ route('client.search') }}',
                    type:"POST",
                    data: function (term, page) {
                        return {
                            q: term, // search term
							rate_type: $("#type_rate").val(),
                            "_token" : "{{ csrf_token() }}"
                        };
                    },
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    }
                },
                placeholder: "{{ $client_name }}",
                templateSelection: function(data){
					$("#client").val(data.id);
					$("#rate_price").val(data.rate_price);
					return data.text;
                }
            });

            $('.select2_lg').select2({
                ajax: {
                    url: '{{ route('linguist.search') }}',
                    type:"POST",
                    data: function (term, page) {
                        return {
                            q: term, // search term
                            "_token" : "{{ csrf_token() }}"
                        };
                    },
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    }
                },
                templateSelection:function(data){
                    $("#linguist").val(data.id);
                    $("#rate_word").val(data.rate_word);
                    $("#rate_hourly").val(data.rate_hourly);
                    return data.text;
				}
            });

            dataTable = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                paging: false,
                searching: false,
                "ajax": {
                    "url" : "{{ route('project.lgajax') }}",
                    "type" : "POST",
                    "dataType": "jsonp",
                    "data" : {
                        "_token" : "{{ csrf_token() }}",
                        "project_id" : "{{ $project->id }}"
                    }
                },
                "columns": [
                    { "data": "linguist" },
                    { "data": "status" },
                    { "data": "price" },
                    { "data": "late" },
                    { "data": "actions" }
                ]
            } );

        });

        function calPrice(value){
            $("#total_price").val($("#rate_price").val()*value);
		}

		function calPriceLg(){
			$("#price").val(($("#wc").val()*$("#rate_word").val())+($("#hourly").val()*$("#rate_hourly").val()));
		}

        function saveAjax(){
            $.ajax({
                url:'{{ route('project.saveajax') }}',
                type:'POST',
                dataType: 'jsonp',
                data:{
                    "_token" : "{{ csrf_token() }}",
                    "id" : $("#project_lg_id").val(),
                    "project_id" : "{{ $project->id }}",
					"status" : $("#lg_status").val(),
                    "lg_id" : $("#linguist").val(),
                    "price" : $("#price").val(),
                    "currency" : $("#currency").val(),
					"score": $("#score").val(),
					"wc" : $("#wc").val(),
					"hourly" : $("#hourly").val(),
					"late" : $("#late").val(),
					"note" : $("#note").val()
                },
                success:function(data){
                    if(data.success == 1){
                        cancelForm();
                        dataTable.ajax.reload();
                    }
                }
            });
        }

        function addForm(){
            $("#add-form-btn").hide();
            $("#project_lg_id").val(0);
            $("#lg_status").val("");
            $('#lg_status').material_select();
            $("#linguist").val("");
            $("#price").val("");
            $("#currency").val("");
            $("#wc").val("");
            $("#hourly").val("");
            $("#score").val(0);
            $("#late").val(0);
            $('#late').material_select();
            $("#note").val("");

            $("#select2-select_linguist-container").html("");
            $("#rate_word").val(0);
            $("#rate_hourly").val(0);

            $('#dataTable_wrapper').hide();
            $('.box-add-ajax').show();
        }

        function cancelForm(){
            $("#add-form-btn").show();
            $('.box-add-ajax').hide();
            $('#dataTable_wrapper').show();
		}

        function editForm(id){
            $.ajax({
                url: '{{ route('project.getlg') }}',
                type:'POST',
                dataType: 'jsonp',
                data:{
                    "_token" : "{{ csrf_token() }}",
                    "id" : id
                },
                success: function(data){
                    $("#add-form-btn").hide();
                    $("#project_lg_id").val(id);
                    $("#linguist").val(data.linguist);
                    $("#lg_status").val(data.status);
                    $('#lg_status').material_select();
                    $("#price").val(data.price);
                    $("#currency").val(data.currency);
                    $("#score").val(data.score);
                    $("#wc").val(data.wc);
                    $("#hourly").val(data.hourly);
                    $("#late").val(data.late);
                    $('#late').material_select();
                    $("#note").val(data.note);

                    $("#select2-select_linguist-container").html(data.linguist_name);
                    $("#rate_word").val(data.rate_word);
                    $("#rate_hourly").val(data.rate_hourly);

                    $("#label_currency").addClass('active');
                    $("#label_note").addClass('active');

                    $('#dataTable_wrapper').hide();
                    $('.box-add-ajax').show();
                }
            });
        }

        function deleteForm(id){
            $.ajax({
                url:'{{ route('project.dellg') }}',
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
