/**
 * Change the checkout city field to a dropdown field.
 */
function wc_change_city_to_dropdown( $fields ) {

    global $wpdb;
    $res = $wpdb->get_results("SELECT * FROM cities_codes",ARRAY_A);
    
    $cityArray = array();
    $cityArray[""] = "Select City";
    foreach ($res as $value) {
    
    $cityArray[$value['city']] = $value['city'];
    }

	$city_args = wp_parse_args( array(
		'type' => 'select',
		'options' => $cityArray,
		'input_class' => array(
			'wc-enhanced-select',
		)
	), $fields['shipping']['shipping_city'] );

	$fields['shipping']['shipping_city'] = $city_args;
	$fields['billing']['billing_city'] = $city_args; // Also change for billing field

	wc_enqueue_js( "
	jQuery( ':input.wc-enhanced-select' ).filter( ':not(.enhanced)' ).each( function() {
		var select2_args = { minimumResultsForSearch: 5 };
		jQuery( this ).select2( select2_args ).addClass( 'enhanced' );
	});" );

	return $fields;

}
add_filter( 'woocommerce_checkout_fields', 'wc_change_city_to_dropdown' );
