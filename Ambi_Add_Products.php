<?php
if( !class_exists('Ambi_Add_Products') )
{
	define( 'AMBIPROD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'AMBIPROD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define('AMBIPROD_PLUGIN_DIRNAME', plugin_basename(dirname(__FILE__)));
	define( 'AMBIPROD', 'Ambi_Add_Products' );
	/**
	 * Add/ Edit Products.
	 *
	 */
	class Ambi_Add_Products
	{
		function __construct()
		{
			# Enqueue the JS scripts
			add_action( 'admin_enqueue_scripts',
				array(&$this, 'enqueueScripts'));
			#AJAX calls handler
			add_action('wp_ajax_ajax_action_new',
				array(&$this, 'ambi_request_receiver_new') );

			add_action('wp_ajax_ajax_action_find',
				array(&$this, 'ambi_request_receiver_find') );
		}


		/**
		 * Enqueue the JavaScript files
		 */
		public function enqueueScripts()
		{

			#---------------WHERE TO PUT THE SCRIPTS ON---------------
			# Here you will specify where you want to enqueue the js file to make the ajax request
			//global $current_screen;

			# Only when the user is viewing the owlo_paid_to_teacher screen
			/*if( $current_screen->post_type !== 'post' )
				return;*/
			#---------------WHERE TO PUT THE SCRIPTS OFF --------------
			wp_enqueue_media();
			wp_enqueue_script( 'ajax_request_script',
				AMBIPROD_PLUGIN_URL.'ambi_products.js',
				array( 'jquery' ),
				'0.0',
				true );
			# Send the parameters to the script
			# Security stuff.
			$security_nonce = wp_create_nonce( 'IS_NONCE' );
			wp_localize_script( 'ajax_request_script',
				'security_nonce',
				$security_nonce );
		}

		public function ambi_request_receiver_new()
		{
			# ------------------------- SECURITY VALIDATION ON -----------------------------
			/**
			 * Checks if the nonce of the ajax is valid
			 *
			 * First parameters comes for the wp_nonce_field string
			 * and the second one comes for the ajax parameter
			 */
			if( !check_ajax_referer(IS_NONCE, 'security_nonce') )
				return wp_send_json_error( 'Invalid Nonce'  );
			/**
			 * If the actual user can not update the post
			 * GET OUT OF HERE
			 */
			if( !current_user_can('publish_posts') )
				return wp_send_json_error( 'You are not allow to do this' );

			$input_fields = isset( $_POST['fields'] ) ? sanitize_post($_POST['fields']) : array();
			$field = array();
			foreach ( $input_fields as $key => $val){
				$name = sanitize_text_field($val['name']);
				$field[$name] = sanitize_text_field($val['value']);
			}
			$serial = sanitize_text_field($field['serial']);
			$category = sanitize_text_field($field['category']);
			$location = sanitize_text_field($field['location']);
			$item_name = sanitize_text_field($field['item_name']);
			$availability = sanitize_text_field($field['availability']);
			$long = sanitize_text_field($field['long']);
			$lat = sanitize_text_field($field['lat']);
			$img = sanitize_trackback_urls($field['img']);

			//integrity check
			if(empty($category) || empty($location) || empty($item_name))
				return wp_send_json_error( 'One or more required fields are empty' );

			global $wpdb;
			$wpdb->hide_errors();
			$table_name = $wpdb->prefix . 'ambi_products';

			$row = $wpdb->get_row( "SELECT * FROM $table_name WHERE `serial` = '{$serial}'" );
			if($row){

				//update record
				if(isset($field['delete']) && empty(!$field['delete'])){
					$del = $wpdb->delete( $table_name, array( 'id' => $row->id ) );
					if($del){
						wp_send_json_success('Record Deleted');
					}else{
						wp_send_json_error($wpdb->last_error);
					}
				}else{
					$updateq = $wpdb->update(
						$table_name,
						array(
							'category' => $category,
							'location' => $location,
							'item_name' => $item_name,
							'status' => $availability,
							'long' => $long,
							'lat' => $lat,
							'image'=>$img
						),
						array( 'id' => $row->id )
					);
					if($updateq){
						wp_send_json_success('Record Updated');
					}else{
						wp_send_json_error($wpdb->last_error);
					}
				}

			}else{
				$result_check = $wpdb->insert(
					$table_name,
					array(
						'serial' => $serial,
						'category' => $category,
						'location' => $location,
						'item_name' => $item_name,
						'status' => $availability,
						'long' => $long,
						'lat' => $lat,
						'image'=>$img
					)
				);
				if($result_check){
					wp_send_json_success("Record Added Successfully");
				}else{
					wp_send_json_error($wpdb->last_error);
				}
			}


		}

		/*Find Items*/
		public function ambi_request_receiver_find()
		{
			# ------------------------- SECURITY VALIDATION ON -----------------------------
			/**
			 * Checks if the nonce of the ajax is valid
			 *
			 * First parameters comes for the wp_nonce_field string
			 * and the second one comes for the ajax parameter
			 */
			if( !check_ajax_referer(IS_NONCE, 'security_nonce') )
				return wp_send_json_error( 'Invalid Nonce'  );
			/**
			 * If the actual user can not update the post
			 * GET OUT OF HERE
			 */
			if( !current_user_can('publish_posts') )
				return wp_send_json_error( 'You are not allow to do this' );
			# ------------------------- SECURITY VALIDATION OFF -----------------------------
			# ------------------------ BUSINESS LOGIC ON ---------------------------------------
			/*#Create the request
			# ------------------------ BUSINESS LOGIC OFF --------------------------------------*/
			$field = array();
			foreach ($_POST['fields'] as $key => $val){
				$field[$val['name']] = $val['value'];
			}

			if(!isset($field['serial']) && empty($field['serial']))
				wp_send_json_error($_POST);

			global $wpdb;
			$wpdb->hide_errors();
			$table_name = $wpdb->prefix . 'ambi_products';
			$row = $wpdb->get_row( "SELECT * FROM $table_name WHERE `serial` = '{$field['serial']}'" );

		if($row){
				wp_send_json_success($row);
			}else{
				wp_send_json_error($wpdb->last_error);
			}
		}

	}# End class
	$ambi_add_products = new Ambi_Add_Products();
}