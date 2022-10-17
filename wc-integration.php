<?php

if(isset($_GET['ids']))
{
    include_once WP_PLUGIN_DIR .'/woocommerce/woocommerce.php';
    global $wpdb;
    global $woocommerce;
    global $pagenow;
    ob_start();

    $message = $_GET['message'];
    $ids = $_GET['ids'];
    $user_id = $_GET['user_id'];
    $cart = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}inhe_cart_history Where user_id = $user_id", ARRAY_A);
    if (!isset($cart)){
        $wpdb->query(
            $wpdb->prepare(
                "
                INSERT INTO {$wpdb->prefix}inhe_cart_history
                ( message, products, status, user_id )
                VALUES ( %s, %s, %s, %s )
                ",
                array(
                    $message,
                    $ids,
                    '0',
                    $user_id,
                )
            )
        );
        $cart_id = $wpdb->insert_id;
    } else {
        $wpdb->query( $wpdb->prepare(
            "
                UPDATE {$wpdb->prefix}inhe_cart_history
                SET message = %s , products = %s
                WHERE user_id = %d;
            ",
            $message, $ids, $user_id
        ) );
    }
}


