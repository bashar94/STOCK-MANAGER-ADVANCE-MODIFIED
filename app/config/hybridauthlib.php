<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
/* HybridAuth Guide: http://hybridauth.github.io/hybridauth/userguide.html
/* ------------------------------------------------------------------------- */

$config =
	array(

		'Hauth_base_url' => 'social_auth/endpoint',

		"providers" => array (

			"Google" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"Facebook" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
				"scope"   => "email, public_profile, user_birthday",
			),

			"Twitter" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Yahoo" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"Live" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"MySpace" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"OpenID" => array (
				"enabled" => false
			),

			"LinkedIn" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"AOL"  => array (
				"enabled" => false
			),
		),

		"debug_mode" => (ENVIRONMENT != 'production'),
		"debug_file" => APPPATH.'logs/hybridauth'.date('Y-m-d').'.php',
	);
