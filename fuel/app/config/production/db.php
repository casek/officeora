<?php
/**
 * The production database settings. These get merged with the global settings.
 */

return array(
	'master' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=ssbs',
			'username'   => 'webuser',
			'password'   => 'bringyourbrain',
		),
	),
);
