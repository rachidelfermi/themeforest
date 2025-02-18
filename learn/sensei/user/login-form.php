<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The Template for displaying the sensei login form
 *
 * Override this template by copying it to yourtheme/sensei/user/login-form.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
?>

<?php
/**
 *  Executes before the Sensei Login form markup begins.
 *
 * @since 1.9.0
 */
do_action( 'sensei_login_form_before' );
?>

<h2><?php esc_html_e( 'Login', 'learn' ); ?></h2>

<form method="post" name="sensi-login-form" id="loginform" class="login sensei">

    <?php
    /**
     *  Executes inside the sensei login form before all the default fields.
     *
     * @since 1.6.2
     */
        do_action( 'sensei_login_form_inside_before' );
    ?>

	<div class="form-group">

				<input type="text" name="log" id="sensei_user_login" class="input form-control" placeholder="E-mail or Username">
                <span class="input-icon"><i class=" icon-user"></i></span>

	</div>

	<div class="form-group">

				<input type="password" name="pwd" id="sensei_user_pass" class="input txt text form-control" placeholder="Password">
                <span class="input-icon"><i class="icon-lock"></i></span>
	</div>

    <div class="small">
        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'learn' ); ?></a>
    </div>

    <?php
    /**
     *  Executes inside the sensei login form after the password field.
     *
     *  You can use the action to add extra form login fields.
     *
     * @since 1.6.2
     */
        do_action( 'sensei_login_form_inside_after_password_field' );
    ?>

	<div class='sensei-login-submit'>

		<input type="submit" class="button" name="login" value="<?php esc_html_e( 'Login', 'learn' ); ?>" />

	</div>

    <?php
    /**
     *  Executes inside the sensei login form after all the default fields.
     *
     * @since 1.6.2
     */
        do_action( 'sensei_login_form_inside_after' );
    ?>

	<?php wp_nonce_field( 'sensei-login' ); ?>

	<input type="hidden" name="redirect" value="<?php echo esc_url_raw( sensei_get_current_page_url() ) ?>" />

	<input type="hidden" name="form" value="sensei-login" />

	<div class="clear"></div>

</form>

<?php
/**
 *  Executes after the Login form markup closes.
 *
 *  @since 1.9.0
 */
do_action( 'sensei_login_form_after' );
?>