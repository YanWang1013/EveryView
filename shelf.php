<?php
/**
 * Plugin Name: MyShop Shelf
 * Plugin URI: https://localhost
 * Description: Product Generate, Add
 * Author: InHeDEV
 * version: 1.0.0
 * Author URI: https://inhedeveloper.com
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class ShopSelf
{

    public function __construct()
    {
        if (!$this->is_bot()) {
            if (isset($_POST['sid'])) {
                require('inc/function.php');
            }
            require('wc-integration.php');
            if (is_admin()) {
                add_action('wp_enqueue_scripts', array($this, 'shelf_admin_enqueue'));
            } else {
                add_action('wp_enqueue_scripts', array($this, 'shelf_frontend_enqueue'));
            }
            $this->require_source();
        }
    }

    private function is_bot()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return false;
        $crawlers_agents = strtolower('Bloglines subscriber|Dumbot|Sosoimagespider|QihooBot|FAST-WebCrawler|Superdownloads Spiderman|LinkWalker|msnbot|ASPSeek|WebAlta Crawler|Lycos|FeedFetcher-Google|Yahoo|YoudaoBot|AdsBot-Google|Googlebot|Scooter|Gigabot|Charlotte|eStyle|AcioRobot|GeonaBot|msnbot-media|Baidu|CocoCrawler|Google|Charlotte t|Yahoo! Slurp China|Sogou web spider|YodaoBot|MSRBOT|AbachoBOT|Sogou head spider|AltaVista|IDBot|Sosospider|Yahoo! Slurp|Java VM|DotBot|LiteFinder|Yeti|Rambler|Scrubby|Baiduspider|accoona');
        $crawlers = explode("|", $crawlers_agents);
        foreach ($crawlers as $crawler) {
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), trim($crawler)) !== false) {
                return true;
            }
        }
        return false;
    }

    public function shelf_frontend_enqueue()
    {
        wp_register_style('shelf-custom-front-style', plugins_url('frontend/css/custom.css', __FILE__));
        wp_enqueue_style('shelf-custom-front-style');
        wp_register_style('shelf-ol-front-style', plugins_url('vendor/openLayer6.4.3/ol.css', __FILE__));
        wp_enqueue_style('shelf-ol-front-style');

        wp_register_script('shelf-polyfill-front-script', '//cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,fetch,Function.prototype.bind,es5&flags=always,gated&unknown=polyfill');
        wp_enqueue_script('shelf-polyfill-front-script');
        wp_register_script('shelf-ol-front-script', plugins_url('vendor/openLayer6.4.3/ol.js', __FILE__));
        wp_enqueue_script('shelf-ol-front-script');
    }

    public function shelf_admin_enqueue()
    {
     echo "not availble";
    }

    public function require_source()
    {
        if (is_admin()) {
            require('admin/shelf-admin.php');
        } else {
            require('frontend/shelf-front.php');
        }
    }
}

$shop_shelf = new ShopSelf();
add_action('shop_shelf_plugin', $shop_shelf);




register_activation_hook( __FILE__, 'my_plugin_create_db' );

function my_plugin_create_db() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'inhe_cart_history';
    $table_name1 = $wpdb->prefix . 'inhe_myshop_shelves';

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		message TEXT NOT NULL,
		products VARCHAR(255) NOT NULL,
		user_id VARCHAR(255) NOT NULL,
		status VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

    $sql1 = "CREATE TABLE $table_name1 (
      tbl_image_id int(11) NOT NULL AUTO_INCREMENT,
      shelve_name varchar(255) NOT NULL,
      shelve_description varchar(255) NOT NULL,
      image_location varchar(255) NOT NULL,
      tile_source varchar(255) NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql1 );
    dbDelta( $sql );
}