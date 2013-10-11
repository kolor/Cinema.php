<?php

return array(

	'default' => 'smtp',

	/*
	|--------------------------------------------------------------------------
	| Swift Mailer Transports
	|--------------------------------------------------------------------------
	|
	| Below is the configuration for each of the Swift Mailer transports. For
	| more information refer to:
	|
	|	http://swiftmailer.org/docs/sending.html
	| 
	|
	| If you want to use Gmail as your email transport, set
	|	'host'       =>	'smtp.gmail.com', 
	|	'username'   =>	'username@gmail.com',
	|	'password'   =>	'password',
	|	'port'       =>	465,
	|	'encryption' =>	'ssl',
	*/

	'transports' => array(

		'smtp' => array(
			'host'       => 'smtp.gmail.com',
			'port'       => 465,
			'username'   => 'airydev@gmail.com',
			'password'   => 'airyairy',
			'encryption' => 'ssl',
		),

		'sendmail' => array(
			'command' => '/usr/sbin/sendmail -bs',
		),

		'mail',

	),
);
