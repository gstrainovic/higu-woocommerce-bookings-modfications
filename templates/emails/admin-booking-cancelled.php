<?php
/**
 * Admin booking cancelled email.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-bookings/emails/admin-booking-cancelled.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/bookings-templates/
 * @author  Automattic
 * @version 1.10.0
 * @since   1.7.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_email_header', $email_heading, $email );
?>

<p><?php esc_html_e( 'The following booking has been cancelled. The details of the cancelled booking can be found below.', 'woocommerce-bookings' ); ?></p>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<tbody>
		<?php if ( $booking->get_product() ) : ?>
			<tr>
				<th scope="row" style="text-align:left; border: 1px solid #eee;"><?php esc_html_e( 'Booked Product', 'woocommerce-bookings' ); ?></th>
				<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_product()->get_title() ); ?></td>
			</tr>
		<?php endif; ?>
		<tr>
			<th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Booking ID', 'woocommerce-bookings' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_id() ); ?></td>
		</tr>
		<?php
		$resource = $booking->get_resource();
		$resource_label = $booking->get_product()->get_resource_label();

		if ( $booking->has_resources() && $resource ) :
			?>
			<tr>
				<th style="text-align:left; border: 1px solid #eee;" scope="row"><?php echo ( '' !== $resource_label ) ? esc_html( $resource_label ) : esc_html__( 'Booking Type', 'woocommerce-bookings' ); ?></th>
				<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $resource->post_title ); ?></td>
			</tr>
		<?php endif; ?>
		<tr>
			<th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Booking Start Date', 'woocommerce-bookings' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_start_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
		</tr>
		<tr>
			<th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Booking End Date', 'woocommerce-bookings' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_end_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
		</tr>
		<?php if ( wc_should_convert_timezone( $booking ) ) : ?>
		<tr>
			<th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Time Zone', 'woocommerce-bookings' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( str_replace( '_', ' ', $booking->get_local_timezone() ) ); ?></td>
		</tr>
		<?php endif; ?>
		<?php if ( $booking->has_persons() ) : ?>
			<?php
			foreach ( $booking->get_persons() as $id => $qty ) :
				if ( 0 === $qty ) {
					continue;
				}

				$person_type = ( 0 < $id ) ? get_the_title( $id ) : __( 'Person(s)', 'woocommerce-bookings' );
				?>
				<tr>
					<th style="text-align:left; border: 1px solid #eee;" scope="row"><?php echo esc_html( $person_type ); ?></th>
					<td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $qty ); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

<p>
<?php
/* translators: 1: a href to booking */
echo wp_kses_post( make_clickable( sprintf( __( 'You can view and edit this booking in the dashboard here: %s', 'woocommerce-bookings' ), admin_url( 'post.php?post=' . $booking->get_id() . '&action=edit' ) ) ) );
?>
</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
