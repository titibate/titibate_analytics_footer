<?php
/*
Plugin Name: Analytics in the footer - Titibate
Description: Add analytics tracking code in the footer page
Version: 0.1
Author: Titibate
Author URI: https://titibate.com
License: GPL3
License URI: https://www.gnu.org/licenses/gpl.html
*/
 
// HOOK footer
add_action("wp_footer", "ttb_afooter");
 
// FUNCTION
function ttb_afooter()
{
	if (defined('WP_TTB_ANALYTICS')) {
	  echo '<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=' . WP_TTB_ANALYTICS . '"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag("js", new Date());

	  gtag("config", "' . WP_TTB_ANALYTICS . '");
	</script>';
	}
}