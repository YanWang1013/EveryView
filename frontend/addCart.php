<?php

// require_once ('./../wp-load.php');
// require_once('./../wp-admin/includes/image.php');
// require_once('./../wp-admin/includes/file.php');
// require_once('./../wp-admin/includes/media.php');
// $wordpress_upload_dir = wp_upload_dir();

// $sid=$_POST["sid"]; 
// $p_image=$_POST["imgBase64"];


// $date = new DateTime();
// $ddstr = $date->format('Y_m_d_H_i_s');

// $fileName = "auto".$ddstr.".png";
// $imgURL = $wordpress_upload_dir['path'] . '/' . $fileName;

// $ifp = fopen( $imgURL, 'wb' ); 
// // split the string on commas
// // $data[ 0 ] == "data:image/png;base64"
// // $data[ 1 ] == <actual base64 string>
// $data = explode( ',', $p_image );
// fwrite( $ifp, base64_decode( $data[ 1 ] ) );
// fclose( $ifp );

// $wp_filetype = wp_check_filetype( $imgURL, null );
// $upload_id = wp_insert_attachment( array(
//     'guid' => $imgURL,
//     'post_mime_type' =>  $wp_filetype['type'],
//     'post_title'     => preg_replace( '/\.[^.]+$/', '', $fileName ),
//     'post_content'   => 'my description',
//     'post_status'    => 'inherit'
// ), $imgURL );

// $attach_data = wp_generate_attachment_metadata( $upload_id, $imgURL );
// wp_update_attachment_metadata( $upload_id, $attach_data );

// // add product 
// $objProduct = new WC_Product();
// //$objProduct = new WC_Product_Variable();

// // $user = wp_get_current_user();
// $p_name = "מוצר אוטומטיz- ".strtotime("now");

// $objProduct->set_name($p_name);
// $objProduct->set_status("publish");  // can be publish,draft or any wordpress post status
// $objProduct->set_catalog_visibility('visible'); // add the product visibility status
// $objProduct->set_description("Selected from shelve by user");
// //$objProduct->set_sku("product-sku"); //can be blank in case you don't have sku, but You can't add duplicate sku's
// //$objProduct->set_price(0); // set product price
// $objProduct->set_regular_price(0); // set product regular price
// $objProduct->set_manage_stock(false); // true or false
// $objProduct->set_stock_quantity(10);
// $objProduct->set_stock_status('instock'); // in stock or out of stock value
// $objProduct->set_backorders('no');
// $objProduct->set_reviews_allowed(true);
// $objProduct->set_sold_individually(false);
// $objProduct->set_category_ids(array(32)); // array of category ids, You can get category id from WooCommerce Product Category Section of Wordpress Admin
// $objProduct->set_image_id($upload_id);
// $product_id = $objProduct->save();

// $data = array("result" => $product_id);

// //$to = "inhedeveloper@hotmail.com";
// //$to = "aweas_rammal@yahoo.com";
// $to = "hmwangyan0349@hotmail.com";
// $subject = "New Product has been added from shop";
// $message = "<b>New Product added from a customer.</b>";
// $message .= "<h1>Get into shop admin and see that product & order.</h1>";
// $header = "From:admin@every-view.com \r\n";
// $header .= "MIME-Version: 1.0\r\n";
// $header .= "Content-type: text/html\r\n";
// $retval = wp_mail ($to,$subject,$message,$header);

// if( $retval == true ) {
// echo "Message sent successfully...";
// return;
// }else {
// echo "Message could not be sent...";
// return;
// }
// echo json_encode($data);

?>