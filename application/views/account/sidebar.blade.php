<?
echo Navigation::lists(
	Navigation::links(array(

		array(Navigation::HEADER, 'Account'),
		array('Overview', '/account', true, false, null, 'user'),
		array('Edit Profile', '/account/edit', false, false, null, 'pencil'),
		array('Security', '/account/security', false, false, null, 'lock'),	

		array(Navigation::HEADER, 'Social'),
		array('Wall', '/social', false, false, null, 'edit'),
		array('Inbox', '/social/inbox', false, false, null, 'envelope'),
		array('Friends', '/social/friends', false, false, null, 'group'),
		
		array(Navigation::HEADER, 'Settings'),
		array('Preferences', '/account/preferences', false, false, null, 'wrench'),
		array('Notifications', '/account/notifications', false, false, null, 'flag'),
		array('Sharing', '/account/sharing', false, false, null, 'globe'),

		array(Navigation::DIVIDER),
		array('Help', '#', false, false, null, 'flag'),
	))
);