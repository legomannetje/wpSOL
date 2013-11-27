<?php
/*
Plugin Name: wpSOL
Plugin URI: http://bitbucket.org/gerritjanf/wpsol
Description: Connect WordPress to the Scouting Nederland OpenID Server
Author: Gerrit Jan
Author URI: http://gerritjanfaber.nl
Version: 0.2
License: 
Text Domain: wpSOL
*/

require 'openid.php';
require 'common.php';

require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_241( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));

// Init wpsol-plugin
function wpsol_init()
{
	// Gebruikersnaam veld toevoegen aan de login pagina
	add_action( 'login_form', 'wpsol_wp_login_form' ); 
	add_filter( 'login_form_middle', 'wpsol_wp_login_form_middle' ); 

	// Inhaken op het authenticatie process
	add_filter('authenticate',  'wpsol_authenticate_username_password', 9);

	// Registreer sidebar widget
	register_sidebar_widget('SOL Sidebar Login', 'wpsol_sidebar_login');
}
add_action("plugins_loaded", "wpsol_init");

// Init wpsol-admin
function wpsol_admin_menu() {
	add_options_page( 'wpSOL', 'wpSOL', 'manage_options', 'wpsol_settings', 'wpsol_admin_options' );
}
add_action( 'admin_menu', 'wpsol_admin_menu' );