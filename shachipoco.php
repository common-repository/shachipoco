<?php
defined('ABSPATH') or die();
/*
Plugin Name: ShaChiPoCo
Description: The main color and key color of Twenty Fourteen can be easily changed by a theme customizer.
Version: 1.1.0
Plugin URI: https://visualive.jp/
Author: kuck1u
Author URI: https://visualive.jp/
License: GPLv2
Text Domain: shachipoco
Domain Path: /langs
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

$wpscpc_is_twentyfourteen = ( get_option( 'template' ) == 'twentyfourteen' ) ? true : false ;

define( 'WPSCPC_VERSION', '1.1.0' );
define( 'WPSCPC_IS_TWENTYFOURTEEN', $wpscpc_is_twentyfourteen );
define( 'WPSCPC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPSCPC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPSCPC_TEXTDOMAIN', 'shachipoco' );

if ( WPSCPC_IS_TWENTYFOURTEEN ) {
    require_once( WPSCPC_PLUGIN_PATH . 'incs/customizer.php' );
}

function _wpscpc_plugins_loaded() {
    load_plugin_textdomain( WPSCPC_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/langs' );
}
add_action( 'plugins_loaded', '_wpscpc_plugins_loaded' );

// Warning message
function wpscpc_show_message_callback( $message, $errormsg = false ) {
    if ( WPSCPC_IS_TWENTYFOURTEEN ) return;

    if ( $errormsg ) {
        echo '<div id="message" class="error">';
    } else {
        echo '<div id="message" class="updated fade">';
    }   echo "<p><strong>$message</strong></p></div>";
}
function _wpscpc_show_admin_messages() {
    wpscpc_show_message_callback( __( 'Theme "Twenty Fourteen" is not enabled. Please enable "Twenty Fourteen" in Themes.', WPSCPC_TEXTDOMAIN ), true );
}
add_action( 'admin_notices', '_wpscpc_show_admin_messages' );
