@extends('layout')

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('currency.update') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Edit Project Type</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="id" value="{{ $currency->id }}" />
							<input type="submit" value="Save" class="waves-effect waves-light btn right" />
							<a href="{{ route('currency.index') }}" class="waves-effect waves-light btn red right">
								Cancel
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col s12">

							<div class="row">
								<div class="input-field col s12">
									<input id="name" name="name" type="text" value="{{ $currency->name }}" class="validate">
									<label for="name">Name</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input id="rate" name="rate" type="text" class="validate" value="{{ $currency->rate }}" placeholder="20.00">
									<label for="rate">Rate</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<input id="symbol" name="symbol" type="text" value="{{ $currency->symbol }}" class="validate">
									<label for="symbol">Symbol</label>
								</div>
							</div>

							<div class="input-field col s12">
								<select id="position" name="position">
									<option value="0" @if($currency->position == 0){{ "selected" }}@endif>Before Price</option>
									<option value="1" @if($currency->position == 1){{ "selected" }}@endif>After Price</option>
								</select>
								<label for="position">Symbol Position</label>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
