<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		@yield('title')
	</title>
	<meta name="viewport" content="width=device-width">
	{{ Asset::container('bootstrapper')->styles() }}
	{{ Asset::container('bootstrapper')->scripts() }}
	{{ HTML::style('css/font-awesome.min.css')}}
	{{ HTML::style('css/styles.css')}}
	{{ Asset::styles() }}
	{{ Asset::scripts() }}
</head>
<body>
	<nav>
		<?php 
		if (Auth::check()) {
			$auth_links = array('<i class="icon-user"></i> '.Auth::user()->username,'account', false,false, array(
				array('Profile', URL::to('account')),
				array('Inbox', URL::to('account/inbox')),
				array('Settings', URL::to('account/settings')),
				array('Logout', URL::to('user/logout')),
			));
		} else {
			$auth_links = $auth_links = array('<i class="icon-user"></i> Account','account', false,false, array(
				array('Signup', URL::to('user/signup')),
				array('Login', URL::to('user/login')),
				array('Recover', URL::to('user/recover')),
			));
		}
						
		echo Navbar::create()->with_brand('Cinemator', URL::to('/')
			 )->with_menus(
		     	Navigation::links(array(
					array('Top', URL::to('top')),
					array('Lists', URL::to('lists')),
					array('Search', URL::to('search')),
			 	))
			 )->with_menus(
				Navigation::links(array(
					array(Navigation::VERTICAL_DIVIDER),
					$auth_links
				)),
				array('class' => 'pull-right')
			)
		?>
	</nav>
	<div class="wrap">
		@yield('sidebar')
		@yield('content')
	</div>
</body>
</html>
