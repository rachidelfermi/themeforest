<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$customer_orders = get_posts( array(
    'numberposts' => $order_count,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => 'shop_order',
    'post_status' => 'publish'
) );

if ( $customer_orders ) : ?>

	<h2><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'Recent Orders', 'ebor_starter' ) ); ?></h2>

	<table class="shop_table my_account_orders">

		<thead>
			<tr>
				<th class="order-number"><span class="nobr"><?php _e( 'Order', 'ebor_starter' ); ?></span></th>
				<th class="order-date"><span class="nobr"><?php _e( 'Date', 'ebor_starter' ); ?></span></th>
				<th class="order-status"><span class="nobr"><?php _e( 'Status', 'ebor_starter' ); ?></span></th>
				<th class="order-total"><span class="nobr"><?php _e( 'Total', 'ebor_starter' ); ?></span></th>
				<th class="order-actions">&nbsp;</th>
			</tr>
		</thead>

		<tbody><?php
			foreach ( $customer_orders as $customer_order ) {
				$order = new WC_Order();

				$order->populate( $customer_order );

				$status     = get_term_by( 'slug', $order->status, 'shop_order_status' );
				$item_count = $order->get_item_count();

				?><tr class="order">
					<td class="order-number">
						<a href="<?php echo esc_url( add_query_arg('order', $order->id, get_permalink( woocommerce_get_page_id( 'view_order' ) ) ) ); ?>">
							<?php echo $order->get_order_number(); ?>
						</a>
					</td>
					<td class="order-date">
						<time datetime="<?php echo date('Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
					</td>
					<td class="order-status" style="text-align:left; white-space:nowrap;">
						<?php echo ucfirst( __( $status->name, 'ebor_starter' ) ); ?>
					</td>
					<td class="order-total">
						<?php echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'ebor_starter' ), $order->get_formatted_order_total(), $item_count ); ?>
					</td>
					<td class="order-actions">
						<?php
							$actions = array();

							if ( in_array( $order->status, apply_filters( 'woocommerce_valid_order_statuses_for_payment', array( 'pending', 'failed' ), $order ) ) )
								$actions['pay'] = array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay', 'ebor_starter' )
								);

							if ( in_array( $order->status, apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) )
								$actions['cancel'] = array(
									'url'  => $order->get_cancel_order_url(),
									'name' => __( 'Cancel', 'ebor_starter' )
								);

							$actions['view'] = array(
								'url'  => add_query_arg( 'order', $order->id, get_permalink( woocommerce_get_page_id( 'view_order' ) ) ),
								'name' => __( 'View', 'ebor_starter' )
							);

							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

							foreach( $actions as $key => $action ) {
								echo '<a href="' . esc_url( $action['url'] ) . '" class="button">' . esc_html( $action['name'] ) . '</a>';
							}
						?>
					</td>
				</tr><?php
			}
		?></tbody>

	</table>

<?php endif; ?>
