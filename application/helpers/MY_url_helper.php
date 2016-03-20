<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('assets_url'))
{
	/**
	 * Assets URL
	 *
	 * Create a local assets URL based on your basepath.
	 *
	 * @return	string
	 */
	function assets_url()
	{
		return get_instance()->config->slash_item('assets_url');
	}
}