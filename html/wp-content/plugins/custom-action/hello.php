<?php
/**
 * @package custom-action
 * @version 0.0.2
 */
/*
Plugin Name: Custom printing action
Description: Actions for printing
Author: S10707
Version: 0.0.1
Author URI: http://sample.pl
*/

function addCustomActionPrinting( $actions ) {
	global $theorder;

	if ( ! $theorder->is_paid() || get_post_meta( $theorder->id, '_wc_order_marked_printing', true ) ) {
		return $actions;
	}

	$actions['wc_custom_order_action'] = __( 'Mark as printed for packaging', 'order-printing' );
	return $actions;
}
add_action( 'woocommerce_order_actions', 'addCustomActionPrinting' );


function processPrintingOrderMessage( $order ) {
	$message = sprintf( __( 'Order printing by %s.', 'order-printing' ), wp_get_current_user()->display_name );
	$order->add_order_note( $message );

	update_post_meta( $order->id, '_wc_order_marked_printing', 'yes' );
}
add_action( 'woocommerce_order_action_wc_custom_order_action', 'processPrintingOrderMessage' );