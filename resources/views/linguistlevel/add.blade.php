@extends('layout')

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('linguistlevel.store') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Add Linguist Rate</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="submit" value="Save" class="waves-effect waves-light btn right" />
							<a href="{{ route('linguistlevel.index') }}" class="waves-effect waves-light btn red right">
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
									<input id="rate_word" name="rate_word" type="text" value="" >
									<label for="rate_word">Rate / Words</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input id="rate_hourly" type="text" name="rate_hourly" value="" >
									<label for="rate_hourly">Rate / Hourly</label>
								</div>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
