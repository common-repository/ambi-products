<?php
class Ambi_Products_Options
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'ambi_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function ambi_add_plugin_page()
    {
        // This page will be under "Settings"
        add_plugins_page(
            'Settings Admin', 
            'Ambi Products',
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <style type="text/css">
            .success-message{color: #00a906; font-weight: 600;}
        </style>
        <div class="wrap">
        <h1>Products Information</h1>
        <form method="post" id="ambi_get_products">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">Find By Serial No</th>
                    <td><input type="text" id="find-serial" name="serial" value="">
                        <span class="find-message"></span>
                        <?php submit_button('Find','default');?></td>
                </tr>
                </tbody>
            </table>
        </form>
            <form method="post" action="" id="ambi_add_products">
	            <?php wp_nonce_field(); ?>
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-products-admin' );
            ?>
                <span class="message"></span>
                <?php submit_button();?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

	    add_settings_section(
		    'setting_section_id', // ID
		    'Add/Edit Products', // Title
		    array( $this, 'print_section_info' ), // Callback
		    'my-products-admin' // Page
	    );

	    add_settings_field(
            'serial', // ID
            'Serial No', // Title
            array( $this, 'serial_callback' ), // Callback
            'my-products-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'category',
            'Category',
            array( $this, 'category_callback' ),
            'my-products-admin',
            'setting_section_id'
        );


	    add_settings_field(
		    'location',
		    'Location',
		    array( $this, 'location_callback' ),
		    'my-products-admin',
		    'setting_section_id'
	    );

	    add_settings_field(
		    'item_name',
		    'Item Name',
		    array( $this, 'item_name_callback' ),
		    'my-products-admin',
		    'setting_section_id'
	    );

	    add_settings_field(
		    'availability',
		    'Availability',
		    array( $this, 'availability_callback' ),
		    'my-products-admin',
		    'setting_section_id'
	    );



	    add_settings_field(
		    'long',
		    'Geo Tag',
		    array( $this, 'long_callback' ),
		    'my-products-admin',
		    'setting_section_id'
	    );
	    add_settings_field(
		    'image',
		    'Image',
		    array( $this, 'img_callback' ),
		    'my-products-admin',
		    'setting_section_id'
	    );

	    add_settings_field(
	    'delete',
	    '',
	    array( $this, 'delete_callback' ),
	    'my-products-admin',
	    'setting_section_id'
    );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['serial'] ) )
            $new_input['serial'] = absint( $input['serial'] );

        if( isset( $input['category'] ) )
            $new_input['category'] = sanitize_text_field( $input['category'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your Product info below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function serial_callback()
    {
        printf(
            '<input type="text" id="serial" name="serial" value="%s" />',
            isset( $this->options['serial'] ) ? esc_attr( $this->options['serial']) : ''
        );
    }

	public function img_callback()
	{
		printf(
			'<button type="button" class="button link" id="ambi_image_upload_button">Select an Image</button><input type="hidden" id="ambi_product_image" name="img" value="" />'
		);
	}

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="title" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }

	public function category_callback()
	{
	    $settings = get_option('my_option_name_key');
	    $categories = str_getcsv($settings['categories']);
	    $catoption = '';
	    foreach ($categories as $val){
	        $opt = str_replace(' ','_', $val);
		    $catoption .=  "<option value=\"$opt\">$val</option>";
        }
        $empty_message = ($catoption=='') ? '<p>You cannot proceed without categories</p>':'';
		printf('<select id="category" name="category">'.$catoption.
                '</select>'.$empty_message
        );
	}

	public function location_callback()
	{
		printf(
			'<input type="text" id="location" name="location" value="" />',
			isset( $this->options['location'] ) ? esc_attr( $this->options['location']) : ''
		);
	}

	public function item_name_callback()
	{
		printf(
			'<input type="text" id="item_name" name="item_name" value="%s" />',
			isset( $this->options['item_name'] ) ? esc_attr( $this->options['item_name']) : ''
		);
	}

	public function availability_callback()
	{
		printf('<select id="availability" name="availability">
                <option value="YES">YES</option>
                <option value="NO">NO</option>
                </select>'
		);
	}

	public function delete_callback()
	{
		printf('<div class="delete hide"><label for="delete">Delete This <input type="checkbox" id="delete" name="delete"></label></div>');
	}

	public function long_callback()
	{
		printf(
			'<input type="text" id="long" name="long" value="%s" placeholder="Long"/>',
			isset( $this->options['long'] ) ? esc_attr( $this->options['long']) : ''
		);
		printf(
			'<input type="text" id="lat" name="lat" value="%s" placeholder="Lat"/>',
			isset( $this->options['lat'] ) ? esc_attr( $this->options['lat']) : ''
		);
	}
}

if( is_admin() )
	$ambi_products_options = new Ambi_Products_Options();