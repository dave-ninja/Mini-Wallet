<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => '',
			'client_secret' => '',
			'scope'         => [],
		],

		'google' => [
			'client_id'     => '',
			'client_secret' => '',
			'redirect'      => ''
		],

		'github' => [
			'client_id' => '',
			'client_secret' => '',
			'redirect' => 'http://bet.loc/git',
		],

	]

];