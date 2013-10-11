<?
echo Navigation::lists(
	Navigation::links(array(
		array(Navigation::HEADER, 'Account settings'),
		array('Overview', '/account', true, false, null, 'user'),
		array('Edit Profile', '/account/edit', false, false, null, 'pencil'),
		array('Security', '/account/security', false, false, null, 'lock'),
		array(Navigation::HEADER, 'Messaging'),
		array('Inbox', '/account/inbox', false, false, null, 'envelope'),
		array('Friends', '/account/friends', false, false, null, 'group'),
		array('Wall', '/account/wall', false, false, null, 'edit'),
		array(Navigation::HEADER, 'Settings'),
		array('Preferences', '/account/preferences', false, false, null, 'wrench'),
		array('Notifications', '/account/notifications', false, false, null, 'flag'),
		array('Sharing', '/account/sharing', false, false, null, 'globe'),

		array(Navigation::DIVIDER),
		array('Help', '#', false, false, null, 'flag'),
	))
);