@extends('layout')

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('linguistlevel.update') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Edit Linguist Level</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="id" value="{{ $linguistlevel->id }}" />
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
									<input id="name" name="name" type="text" value="{{ $linguistlevel->name }}" class="validate">
									<label for="name">Name</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input id="rate_word" name="rate_word" type="text" value="{{ $linguistlevel->rate_word }}" >
									<label for="rate_word">Rate / Words</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input id="rate_hourly" type="text" name="rate_hourly" value="{{ $linguistlevel->rate_hourly }}" >
									<label for="rate_hourly">Hourly</label>
								</div>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
