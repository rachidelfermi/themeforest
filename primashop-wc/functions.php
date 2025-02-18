<?php
/**
 * PrimaShop functions and definitions.
 *
 * WARNING: This file is part of the PrimaShop parent theme.
 * DO NOT edit this file under any circumstances. 
 * Please do all modifications in the form of a child theme.
 *
 * @category PrimaShop
 * @package  Templates
 * @author   PrimaThemes
 * @link     http://www.primathemes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'PRIMA_THEME_VERSION', '1.8.3' );
define( 'PRIMA_THEME_SETTINGS', 'primashop' );
define( 'PRIMA_DESIGN_SETTINGS', 'primashop_design' );
define( 'PRIMA_SIDEBAR_SETTINGS', 'primashop_sidebar' );

function prima_load( $file ) {
	include_once( $file );
}

include_once( get_template_directory().'/core/functions/framework.php' );

