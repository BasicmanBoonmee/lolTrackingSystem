@extends('layout')

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('linguist.update') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Edit Linguist</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="id" value="{{ $linguist->id }}" />
							<input type="submit" value="Save" class="waves-effect waves-light btn right" />
							<a href="{{ route('linguist.index') }}" class="waves-effect waves-light btn red right">
								Cancel
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="row">
								<div class="input-field col s12">
									<input id="name" name="name" type="text" value="{{ $linguist->name }}" class="validate">
									<label for="name">Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="guaranteed_income" name="guaranteed_income" type="number" value="{{ $linguist->guaranteed_income }}" >
									<label for="guaranteed_income">Guaranteed Income</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="daily_capacity" type="number" name="daily_capacity" value="{{ $linguist->daily_capacity }}" >
									<label for="daily_capacity">Daily Capacity</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<select id="linguist_levelFK" name="linguist_levelFK">
										@foreach($linguistlevel as $value)
											<option value="{{ $value->id }}" @if($linguist->linguist_levelFK == $value->id){{ 'selected' }}@endif>{{ $value->name }}</option>
										@endforeach
									</select>
									<label for="linguist_levelFK">Level</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<textarea id="note" name="note" class="materialize-textarea">{{ $linguist->note }}</textarea>
									<label for="note">Note</label>
								</div>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
