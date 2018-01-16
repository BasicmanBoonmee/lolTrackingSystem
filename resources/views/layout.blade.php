<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Title -->
	<title>Alpha | Responsive Admin Dashboard Template</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta charset="UTF-8">
	<meta name="description" content="Responsive Admin Dashboard Template" />
	<meta name="keywords" content="admin,dashboard" />
	<meta name="author" content="Steelcoders" />

	<!-- Styles -->
	<link type="text/css" rel="stylesheet" href="{{ asset('assets/plugins/materialize/css/materialize.css') }}"/>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="{{ asset('assets/plugins/metrojs/MetroJs.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/plugins/weather-icons-master/css/weather-icons.min.css') }}" rel="stylesheet">


	<!-- Theme Styles -->
	<link href="{{ asset('assets/css/alpha.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="http://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	@yield('css')

</head>
<body>
<div class="loader-bg"></div>
<div class="loader">
	<div class="preloader-wrapper big active">
		<div class="spinner-layer spinner-blue">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div><div class="gap-patch">
				<div class="circle"></div>
			</div><div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
		<div class="spinner-layer spinner-teal lighten-1">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div><div class="gap-patch">
				<div class="circle"></div>
			</div><div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
		<div class="spinner-layer spinner-yellow">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div><div class="gap-patch">
				<div class="circle"></div>
			</div><div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
		<div class="spinner-layer spinner-green">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div><div class="gap-patch">
				<div class="circle"></div>
			</div><div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
	</div>
</div>
<div class="mn-content fixed-sidebar">
	<header class="mn-header navbar-fixed">
		<nav class="cyan darken-1">
			<div class="nav-wrapper row">
				<section class="material-design-hamburger navigation-toggle">
					<a href="javascript:void(0)" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
						<span class="material-design-hamburger__layer"></span>
					</a>
				</section>
				<div class="header-title col s3 m3">
					<span class="chapter-title">Local Light Tracking System</span>
				</div>
				<?php /*
				<ul class="right col s9 m3 nav-right-menu">
					<li><a href="javascript:void(0)" data-activates="chat-sidebar" class="chat-button show-on-large"><i class="material-icons">more_vert</i></a></li>
					<li class="hide-on-small-and-down"><a href="javascript:void(0)" data-activates="dropdown1" class="dropdown-button dropdown-right show-on-large"><i class="material-icons">notifications_none</i><span class="badge">4</span></a></li>
					<li class="hide-on-med-and-up"><a href="javascript:void(0)" class="search-toggle"><i class="material-icons">search</i></a></li>
				</ul> */ ?>

				<ul id="dropdown1" class="dropdown-content notifications-dropdown">
					<li class="notificatoins-dropdown-container">
						<ul>
							<li class="notification-drop-title">Today</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle cyan"><i class="material-icons">done</i></div>
										<div class="notification-text"><p><b>Alan Grey</b> uploaded new theme</p><span>7 min ago</span></div>
									</div>
								</a>
							</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle deep-purple"><i class="material-icons">cached</i></div>
										<div class="notification-text"><p><b>Tom</b> updated status</p><span>14 min ago</span></div>
									</div>
								</a>
							</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle red"><i class="material-icons">delete</i></div>
										<div class="notification-text"><p><b>Amily Lee</b> deleted account</p><span>28 min ago</span></div>
									</div>
								</a>
							</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle cyan"><i class="material-icons">person_add</i></div>
										<div class="notification-text"><p><b>Tom Simpson</b> registered</p><span>2 hrs ago</span></div>
									</div>
								</a>
							</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle green"><i class="material-icons">file_upload</i></div>
										<div class="notification-text"><p>Finished uploading files</p><span>4 hrs ago</span></div>
									</div>
								</a>
							</li>
							<li class="notification-drop-title">Yestarday</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle green"><i class="material-icons">security</i></div>
										<div class="notification-text"><p>Security issues fixed</p><span>16 hrs ago</span></div>
									</div>
								</a>
							</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle indigo"><i class="material-icons">file_download</i></div>
										<div class="notification-text"><p>Finished downloading files</p><span>22 hrs ago</span></div>
									</div>
								</a>
							</li>
							<li>
								<a href="#!">
									<div class="notification">
										<div class="notification-icon circle cyan"><i class="material-icons">code</i></div>
										<div class="notification-text"><p>Code changes were saved</p><span>1 day ago</span></div>
									</div>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<aside id="slide-out" class="side-nav white fixed">
		<div class="side-nav-wrapper">
			<div class="sidebar-profile">
				<div class="sidebar-profile-info">
						<p>M</p>
						<span>example@local-light.com</span>
				</div>
			</div>

			<ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
				<li class="no-padding  @if(isset($menu) && $menu == "dashboard"){!! "active" !!}@endif">
					<a class="waves-effect waves-grey @if(isset($menu) && $menu == "dashboard"){!! "active" !!}@endif" href="{{ route('dashboard') }}">
						<i class="material-icons">settings_input_svideo</i>Dashboard
					</a>
				</li>
				<li class="no-padding @if(isset($menu) && $menu == "project"){!! "active" !!}@endif">
					<a class="waves-effect waves-grey @if(isset($menu) && $menu == "project"){!! "active" !!}@endif" href="{{ route('project.index') }}">
						<i class="material-icons">assignment</i>Projects
					</a>
				</li>

				<li class="no-padding @if(isset($menu) && $menu == "linguist"){!! "active" !!}@endif">
					<a class="waves-effect waves-grey @if(isset($menu) && $menu == "linguist"){!! "active" !!}@endif" href="{{ route('linguist.index') }}">
						<i class="material-icons">translate</i>Linguists
					</a>
				</li>

				<li class="no-padding @if(isset($menu) && $menu == "linguistlevel"){!! "active" !!}@endif">
					<a class="waves-effect waves-grey @if(isset($menu) && $menu == "linguistlevel"){!! "active" !!}@endif" href="{{ route('linguistlevel.index') }}">
						<i class="material-icons">verified_user</i>Linguist Level
					</a>
				</li>

				<li class="no-padding @if(isset($menu) && $menu == "client"){!! "active" !!}@endif">
					<a class="waves-effect waves-grey @if(isset($menu) && $menu == "client"){!! "active" !!}@endif" href="{{ route('client.index') }}">
						<i class="material-icons">people</i>Clients
					</a>
				</li>

				<li class="no-padding @if(isset($menu) && $menu == "clientrate"){!! "active" !!}@endif">
					<a class="waves-effect waves-grey @if(isset($menu) && $menu == "clientrate"){!! "active" !!}@endif" href="{{ route('clientrate.index') }}">
						<i class="material-icons">attach_money</i>Client Rate
					</a>
				</li>

				<li class="no-padding">
					<a class="waves-effect waves-grey" href="{{ route('logout') }}">
						<i class="material-icons">exit_to_app</i>Logout
					</a>
				</li>
			</ul>
		</div>
	</aside>
	<main class="mn-inner inner-active-sidebar">
		<div class="middle-content">

			@yield('content')

		</div>

	</main>

</div>
<div class="left-sidebar-hover"></div>


<!-- Javascripts -->
<script src="{{ asset('assets/plugins/jquery/jquery-2.2.0.min.js') }}"></script>
<!--<script src="{{ asset('assets/plugins/jquery/jquery-1.9.1.js') }}"></script>-->
<script src="{{ asset('assets/plugins/materialize/js/materialize.min.js') }}"></script>
<script src="{{ asset('assets/plugins/material-preloader/js/materialPreloader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-blockui/jquery.blockui.js') }}"></script>
<script src="{{ asset('assets/js/alpha.min.js') }}"></script>

@yield('js')


</body>
</html>