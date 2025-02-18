<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
 
$GLOBALS['is_main'] = 1;

get_header(); ?>

<?php
   get_sidebar('start');
   //echo '<div class="rc_spread"></div>';
   get_template_part( 'loop', 'index' );
?>

<?php get_footer(); ?>
