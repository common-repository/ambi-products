<?php
class Ambi_Products_Keys
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
        add_action( 'admin_menu', array( $this, 'ambi_add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function ambi_add_settings_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Ambi Products Settings',
            'manage_options', 
            'my-setting-admin-key',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        $this->options = get_option( 'my_option_name_key' );
        ?>
        <style type="text/css">
            .success-message{color: #00a906; font-weight: 600;}
        </style>
        <div class="wrap">
        <h1>Ambi Products Settings</h1>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'my_option_group_keys' );
                do_settings_sections( 'my-products-admin-key' );
            ?>
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
            'my_option_group_keys', // Option group
            'my_option_name_key', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

	    add_settings_section(
		    'setting_section_key_id', // ID
		    'Set Google Maps API Key & Categories', // Title
		    array( $this, 'print_section_info' ), // Callback
		    'my-products-admin-key' // Page
	    );

	    add_settings_field(
            'key', // ID
            'API Key', // Title
            array( $this, 'key_callback' ), // Callback
            'my-products-admin-key', // Page
            'setting_section_key_id' // Section           
        );

	    add_settings_field(
		    'categories', // ID
		    'Categories', // Title
		    array( $this, 'set_categories_callback' ), // Callback
		    'my-products-admin-key', // Page
		    'setting_section_key_id' // Section
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
        if( isset( $input['key'] ) )
            $new_input['key'] = sanitize_text_field( $input['key'] );

	    if( isset( $input['categories'] ) ){
		    $cat = sanitize_text_field( $input['categories'] );
		    $arr = str_getcsv($cat);
		    $new_input['categories'] = '';
		    foreach ($arr as $value){
			    $new_input['categories'] .= trim($value).',';
            }
		    $new_input['categories'] = rtrim($new_input['categories'], ',');
        }

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your API Key and Categories, without categories you cannot add products:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function key_callback()
    {
        printf(
            '<input type="text" id="my_option_name_key[key]" name="my_option_name_key[key]" value="%s" />',
            isset( $this->options['key'] ) ? esc_attr( $this->options['key']) : ''
        );
    }

	public function set_categories_callback()
	{
		$cat = isset( $this->options['categories'] ) ? esc_attr( $this->options['categories']) : '';
		printf(
			'<textarea placeholder="list each category seperated by comma" type="text" id="my_option_name_key[categories]" name="my_option_name_key[categories]" value="%s" >'. $cat .'</textarea>',''
		);
	}
}

if( is_admin() )
    $ambi_products_keys = new ambi_products_keys();