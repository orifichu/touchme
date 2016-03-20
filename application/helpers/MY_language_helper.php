<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('t'))
{
	function t($line) {
	    global $LANG;
	    return ($t = $LANG->line($line)) ? $t : $line;
	}
}

// ------------------------------------------------------------------------
/* End of file MY_language_helper.php */
/* Location: ./application/helpers/MY_language_helper.php */