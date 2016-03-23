<?php
if (!defined('ABSPATH')) exit;

global $mpsl_settings;
$menuUrl = menu_page_url($mpsl_settings['plugin_name'], false);
?>
<p><?php _e('Please install and activate WooCommerce plugin.', MPSL_TEXTDOMAIN); ?></p>
<a class="button-secondary mpsl-button" href="<?php echo $menuUrl ?>"><?php _e('Close', MPSL_TEXTDOMAIN); ?></a>