@extends('layout')

@section('content')
	<div class="col s12 m12 l6">
		<div class="card">
			<div class="card-content">
				<form action="{{ route('client.store') }}" method="post">
					<div class="row">
						<div class="col s6">
							<span class="card-title">Add Client</span>
						</div>
						<div class="col s6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
									<input id="name" name="name" type="text" class="validate">
									<label for="name">Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="email" name="email" type="email" class="validate">
									<label for="email">Email</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="phone" type="text" name="phone" >
									<label for="phone">Phone number</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="code" name="code" type="text" >
									<label for="code">Code</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="payment_term" name="payment_term" type="number" >
									<label for="payment_term">Payment Term</label>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
