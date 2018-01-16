@extends('layout')

@section('css')
	<link href="{{ asset('assets/plugins/select2/css/select2.css') }}" rel="stylesheet" type="text/css"/>

	<style>
		.select2-container{
			width: 100%;
		}
	</style>

@stop

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('project.store') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Add Project</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
									<input id="name" name="name" type="text" value="" class="validate">
									<label for="name">Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<select id="status" name="status">
										<option value="In Progress">In Progress</option>
										<option value="Delivered">Delivered</option>
										<option value="Closed">Closed</option>
										<option value="Cancelled">Cancelled</option>
										<option value="Pending">Pending</option>
										<option value="Headsup">Headsup</option>
										<option value="On hold">On hold</option>
										<option value="Sent to Invoice">Sent to Invoice</option>
									</select>
									<label for="status">Status</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<select id="type_rate" name="type_rate">
										<option>- Select -</option>
										@foreach($typerate as $value)
											<option value="{{ $value->id }}">{{ $value->name }}</option>
										@endforeach
									</select>
									<label for="type_rate" class="active">Type</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input type="hidden" id="rate_price" />
									<input type="hidden" name="client" id="client" value="" />
									<select id="select_client" class="select2 js-states browser-default" tabindex="-1"></select>
									<label for="select_client" class="active">Client</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input id="unit_total" onkeyup="calPrice(this.value);" type="number" name="unit_total" value="" >
									<label for="unit_total" class="active">WC / Hourly</label>
								</div>
							</div>


							<div class="row">
								<div class="input-field col s12">
									<input id="total_price" type="number" name="total_price" value="" >
									<label for="total_price">Price</label>
								</div>
							</div>

							<div class="row">
								<div class="col s12">
									<label for="dead_line">Client Deadline</label>
									<input id="dead_line" type="text" name="dead_line" class="datepicker" value="" >
								</div>
							</div>

							<div class="row">
								<div class="col s12">
									<label for="start_date">Start Project</label>
									<input id="start_date" type="text" name="start_date" class="datepicker" value="" >
								</div>
							</div>

							<div class="row">
								<div class="col s12">
									<label for="end_date">End Project</label>
									<input id="end_date" type="text" name="end_date" class="datepicker" value="" >
								</div>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop


@section('js')

	<script src="{{ asset('assets/plugins/select2/js/select2.js') }}"></script>

	<script>
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
                        console.log("processResult");
                        console.log(data);
                        return {
                            results: data.items
                        };
                    }
                },
                placeholder: "Select a Client",
                templateSelection: function(data){
                    $("#client").val(data.id);
                    $("#rate_price").val(data.rate_price);
                    return data.text;
                }
            });

        });

        function calPrice(value){
            $("#total_price").val($("#rate_price").val()*value);
        }

	</script>
@stop