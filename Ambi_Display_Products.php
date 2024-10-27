<?php
/**
 * Project: rich
 * File Name: display_products.php
 * Author: Zameel Amjed
 * Date: 7/31/2019
 * Time: 10:21 AM
 */

if( !class_exists('Ambi_Display_Products') )
{

	class Ambi_Display_Products
	{
		function __construct()
		{
			add_action('init', array(&$this,'ambi_products_shortcodes_init'));
		}

		function ambi_products_shortcodes_init()
		{
			wp_register_style( 'ambi-bootstrap4-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.micn.css' );
			wp_register_style( 'ambi-datatables-css', AMBIPROD_PLUGIN_URL.'assets/datatables.min.css' );

			function ambi_list_products($atts = [], $content = null)
			{

				if(!isset($atts['cat']))
					return "set category [ambi-products cat=\"HOARDINGS\"]";

				//CALL DEPENDENCIES FOR DATA TABLES
				if(isset($atts['datatables'])) {
					#wp_enqueue_style( 'ambi-bootstrap4-css' );
					wp_enqueue_style( 'ambi-datatables-css' );
					wp_enqueue_script( 'ambi-datatables',
						AMBIPROD_PLUGIN_URL.'assets/datatables.min.js',
						array( 'jquery' ),
						'0.0',
						true );
				}

				$item_name = (isset($atts['item-name'])) ? $atts['item-name'] : 'Item Name' ;

				global $wpdb;
				$wpdb->hide_errors();
				$table_name = $wpdb->prefix . 'ambi_products';
				$atts['cat'] = preg_replace('/\s+/', '_', $atts['cat']);

				$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE `category` = '{$atts['cat']}' LIMIT 1000" );

				if($results){
					$table = '<table class="table" id="data-table" style="width:100%">';
					$table .= '<thead>
								<tr>
								<th>Serial</th>
								<th>'.$item_name.'</th>
								<th>Location</th>
								<th>Availability</th>
								<th>&nbsp;</th>
								</tr>
								</thead>';
					foreach($results as $val){
						$url = isset($atts['url']) ? "<a class='glyphicon glyphicon-envelope' href='{$atts['url']}?serial={$val->serial}'></a>" : '';

						$table .="<tr>
						<td>{$val->serial}</td>
						<td>{$val->item_name}</td>
						<td>{$val->location}</td>
						<td>{$val->status}</td>
						<td>{$url}</td>
						</tr>";
					}
					$table .= '</tbody></table>';
					return $table;
				}else{
					return '<p>No product found</p>';
				}
			}
			add_shortcode('ambi-products','ambi_list_products');

			/**
			 * Display items in a map
			 * @param array $atts
			 * @param null $content
			 *
			 * @return string
			 */
			function map_items($atts = [], $content = null){

				if(!isset($atts['cat']))
					return "set category [ambi-products-map cat=\"HOARDINGS\"]";

				if(!isset($atts['url']))
					return "set url [ambi-products-map url=\"http:\\\website.com\contact\"]";

				global $wpdb;
				$wpdb->hide_errors();
				$table_name = $wpdb->prefix . 'ambi_products';
				$atts['cat'] = preg_replace('/\s+/', '_', $atts['cat']);

				$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE `category` = '{$atts['cat']}' AND (`long` != '' AND `lat` !='') LIMIT 20" );
//wp_send_json_success($wpdb->last_query);
				$cordinates = [];
				foreach ($results as $val){
					array_push($cordinates, array('lat'=>$val->lat, 'lng'=>$val->long, 'name'=>$val->item_name, 'serial'=>$val->serial , 'image'=>$val->image));
				}
				$settings = get_option('my_option_name_key');
				return print_maps($cordinates, $atts['url'], $settings['key']);
			}
			add_shortcode('ambi-products-map','map_items');

			function ambi_contact_page($atts = [], $content = null){

				if(!isset($atts['form-id']))
					return "";

				if(!isset($atts['field-name']))
					return "";

				$js = <<<EOD
				<script type="text/javascript">
				if(jQuery('#{$atts['form-id']}').length){
					var getSerial = getVar('serial');
					if(getSerial){
						jQuery('input[name={$atts['field-name']}]').val('Inquiry for '+getSerial);
					}
				}
				function getVar(name){
    			if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        		return decodeURIComponent(name[1]);
				}</script>
EOD;


			return $js;
			}
			add_shortcode('ambi-product-inquiry','ambi_contact_page');
		}

	}# End class
	$ambi_display_products = new Ambi_Display_Products();
}