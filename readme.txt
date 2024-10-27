=== AmbiProducts ===

Contributors: zameelamjed
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z48JJTG4LEZRU&source=url
Tags: products table, category, list products, Geotag, products in map, show in map, map markers, coordinates
Requires at least: 4.6
Tested up to: 5.2.2
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add products with categories and geotags and display in a map or embed to section pages using shortcodes

== Description ==

<p>This plugin enables you to add products with categories using geotags then use shortcodes to print a table according to category and display in a map</p>
<p>If you have products listed in different geographical locations this plugin helps you to maintain all in a single table and display in category pages using a map.</p>
<p>Simple case would be a real estate agent with a list of houses distributed across different locations, could insert all listings in a single table then shortcodes can be used in different pages to pull listings according to each category such as apartments, bungalow, condominium and etc.</p>
<p>Map shortcode is used to mark houses in a map and upon click information is shown in a balloon in which user may redirected to a page to inquire about the particular house.</p>

<p>Plugin is checked on wordpress 5.2.2 and fully functional.</p>

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/ambi_products` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Ambi Products Settings screen to configure the plugin
4. Use Google Maps Javascript API to generate a key and paste it
5. List each category seperated by comma e.g. apartments, bungalow, condominium
6. Now you can navigate to Plugins->Ambi Products to add / update products

== Shortcodes ==

= Category =

1. Use **ambi-products** to list products of each category in a table. e.g
`[ambi-products cat="category name" url="link to redirect"][/ambi-products]`

2. Then use **ambi-product-inquiry** shortcode in contact page to capture inquiry for your form (you can use plugins like contact form 7 to add forms)
`[ambi-product-inquiry form-id="my-form-id" field-name="*mail-subject*"][/ambi-product-inquiry]`

Above shortcode is used for a form generated using [contact-form-7](https://wordpress.org/plugins/contact-form-7/)
[contact-form-7 html_id="my-form-id" title="Contact form 1"]
[text mail-subject]

3. If your table consists large number of records use **datatable="true"** attribute to organize it neatly with pagination and search function
`[ambi-products cat="CATEGORY NAME" datatable="true" ][/ambi-products]`

= Plot in Google Map =
1. Use **ambi-products-map** to list products of each category in a map. e.g
`[ambi-products-map cat="category name" url="link to redirect"][/ambi-products-map]`

== Screenshots ==

1. Homepage with plugin `/assets/screenshot-7.png`
2. Activate plugin `/assets/screenshot-1.png`
3. Navigate to Settings page `/assets/screenshot-2.png`
4. Add Google Maps Javascript API Key `/assets/screenshot-3.png`
5. Add Categories and API Key`/assets/screenshot-4.png`
6. Add Products `/assets/screenshot-5.png`
7. Shortcodes `/assets/screenshot-6.png`

== Frequently Asked Questions ==
TBU

== Changelog ==
= 1.5 =
* Integration of DataTables for large number of records
* Automatic capture of product info for the inquiry
* Use images in Map Marker popup window

= 1.0 =
* Plugin with Table and Map

== Upgrade Notice ==

= 1.5 =
Category table is formatted neatly and search function is integrated to display large number of records

= 1.0 =
Initial release of the plugin
