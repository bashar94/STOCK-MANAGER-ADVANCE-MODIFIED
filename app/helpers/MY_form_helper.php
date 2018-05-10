<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Add admin_form_open
if ( ! function_exists('admin_form_open')) {
	function admin_form_open($action = '', $attributes = array(), $hidden = array()) {
		return form_open('admin/'.$action, $attributes, $hidden);
	}
}

// Add admin_form_open_multipart
if ( ! function_exists('admin_form_open_multipart')) {
	function admin_form_open_multipart($action = '', $attributes = array(), $hidden = array()) {
		if (is_string($attributes)) {
			$attributes .= ' enctype="multipart/form-data"';
		} else {
			$attributes['enctype'] = 'multipart/form-data';
		}
		return admin_form_open($action, $attributes, $hidden);
	}
}

// Add shop_form_open
if ( ! function_exists('shop_form_open')) {
	function shop_form_open($action = '', $attributes = array(), $hidden = array()) {
		return form_open('shop/'.$action, $attributes, $hidden);
	}
}

// Add shop_form_open_multipart
if ( ! function_exists('shop_form_open_multipart')) {
	function shop_form_open_multipart($action = '', $attributes = array(), $hidden = array()) {
		if (is_string($attributes)) {
			$attributes .= ' enctype="multipart/form-data"';
		} else {
			$attributes['enctype'] = 'multipart/form-data';
		}
		return shop_form_open($action, $attributes, $hidden);
	}
}
