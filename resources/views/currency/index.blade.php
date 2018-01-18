@extends('layout')

@section('css')
	<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
@stop

@section('content')
	<div class="row">
		@if(isset($alert)) {{ $alert }} @endif
		<div id="alert-box" @if(isset($alert) && $alert != ""){{ "" }} @else {!! 'style="display:none;"' !!} @endif class="col s12">
			<div class="card">
				<div class="card-content @if(isset($alert_color)){{ $alert_color }}@endif" style="color: #ffffff;">
					@if(isset($alert)) {{ $alert }} @endif
				</div>
			</div>
		</div>

		<div class="col s9">
			<div class="page-title">Currency</div>
		</div>
		<div class="col s3 right-align">
			<a href="{{ route('currency.add') }}" class="waves-effect waves-light btn">
				<i class="material-icons left">add</i> Add Currency
			</a>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<table id="dataTable" class="display responsive-table datatable-example">
						<thead>
						<tr>
							<th>Name</th>
							<th>Rate</th>
							<th></th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop

@section('js')
	<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>

	<script>
        $('#dataTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url" : "{{ route('currency.ajax') }}",
				"type" : "POST",
                "dataType": "jsonp",
				"data" : {
                    "_token" : "{{ csrf_token() }}"
				}
            },
            "columns": [
                { "data": "name" },
                { "data": "rate" },
                { "data": "actions" }
            ]
        } );
	</script>

@stop