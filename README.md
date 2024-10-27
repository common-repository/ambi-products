# AmbiProducts

Add products with categories using geotags and display in a map or embed to section pages using shortcodes

## Description

If you have products listed in different geographical locations this plugin helps you to maintain all in a single table and when you need to display based on categories in inner pages you can simply use shortcodes. You can display it in a category table as well as in a map. 

Simple case would be a real estate agent with a list of houses distributed across different locations. Agent can insert all listings in a single table then shortcodes can be used in different pages to pull listings according to each category such as apartments, bungalow, condominium and etc. further, Map shortcode is used to mark houses in a map and upon click more detail is shown in a balloon to redirect user to place an inquiry about the particular house.

<<<<<<< HEAD
=======
Plugin is checked on wordpress 5.2.2 and fully functional.

>>>>>>> db604a08cbb757af70554639e6ac4fe41ba01b89
## Installation

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/ambi_products` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Ambi Products Settings screen to configure the plugin
1. Use Google Maps Javascript API to generate a key and paste it
1. List each category seperated by comma e.g. apartments, bungalow, condominium
1. Now you can navigate to Plugins->Ambi Products to add / update products

## Shortcodes
<<<<<<< HEAD
###Category

1. Use **ambi-products** to list products of each category in a table. e.g
`[ambi-products cat="category name" url="link to redirect"][/ambi-products]`

2. Then use **ambi-product-inquiry** shortcode in contact page to capture inquiry for your form (you can use plugins like contact form 7 to add forms)
`[ambi-product-inquiry form-id="*my-form-id*" field-name="*mail-subject*"][/ambi-product-inquiry]`

    Above shortcode is used for a form generated using [contact-form-7](https://wordpress.org/plugins/contact-form-7/)
`[contact-form-7 html_id="*my-form-id*" title="Contact form 1"]`
`[text mail-subject]`

3. If your table consists large number of records use **datatable="true"** attribute to organize it neatly with pagination and search function
`[ambi-products cat="CATEGORY NAME" datatable="true" ][/ambi-products]`

###Plot in Google Map
1. Use **ambi-products-map** to list products of each category in a map. e.g
`[ambi-products-map cat="category name" url="link to redirect"][/ambi-products-map]`
=======
1. To list products of each category in a table. e.g
##### [ambi-products cat=\"category name\" url=\"link to redirect\"][/ambi-products]
e.g
```[ambi-products cat="CATEGORY NAME" url="http://mywordpresssite.com/contact/houses"][/ambi-products]```
1. To list products of each category in a map. e.g
##### [ambi-products-map cat=\"category name\" url=\"link to redirect\"][/ambi-products-map]

## Screenshots

1. Activate plugin `/assets/screenshot-1.png` 
1. Navigate to Settings page `/assets/screenshot-2.png` 
1. Add Google Maps Javascript API Key `/assets/screenshot-3.png` 
1. Add Categories and API Key`/assets/screenshot-4.png` 
1. Add Products `/assets/screenshot-5.png` 
1. Shortcodes `/assets/screenshot-6.png` 
1. Homepage with plugin `/assets/screenshot-7.png` 
>>>>>>> db604a08cbb757af70554639e6ac4fe41ba01b89
