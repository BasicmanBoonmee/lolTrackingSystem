@extends('layout')

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('clientrate.update') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Edit Project Type</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="id" value="{{ $clientrate->id }}" />
							<input type="submit" value="Save" class="waves-effect waves-light btn right" />
							<a href="{{ route('clientrate.index') }}" class="waves-effect waves-light btn red right">
								Cancel
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="row">
								<div class="input-field col s12">
									<input id="name" name="name" type="text" value="{{ $clientrate->name }}" class="validate">
									<label for="name">Name</label>
								</div>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
