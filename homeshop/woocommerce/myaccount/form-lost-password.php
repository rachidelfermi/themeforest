<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php wc_print_notices(); ?>

<div class="row">
                    	
		<div class="col-lg-12 col-md-12 col-sm-12">
			
			<div class="carousel-heading no-margin">
				<h4><?php _e( 'Change password', 'homeshop' ); ?></h4>
			</div>

			
			<div class="page-content">


<form method="post" class="woocommerce-ResetPassword lost_reset_password">

	<p><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'homeshop' ) ); ?></p>

	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<label for="user_login"><?php _e( 'Username or email', 'homeshop' ); ?></label>
		<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" />
	</p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

	<p class="woocommerce-FormRow form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<input type="submit" class="woocommerce-Button button" style="padding: 5px 15px;"  value="<?php esc_attr_e( 'Reset Password', 'homeshop' ); ?>" />
	</p>

	<?php wp_nonce_field( 'lost_password' ); ?>

</form>





			</div>
			
		</div>
                          
	</div>