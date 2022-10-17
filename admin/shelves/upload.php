<?php

require_once('db.php');
require_once('./../../../wp-load.php');

if (isset($_POST['Submit'])) {
// echo "";
// }else{
// $file=$_FILES['image']['tmp_name'];
// $image = $_FILES["image"] ["name"];
// $image_name= addslashes($_FILES['image']['name']);
// $size = $_FILES["image"] ["size"];
// $error = $_FILES["image"] ["error"];
// 
// if ($error > 0){
// die("Error uploading file! Code $error.");
// }else{
// 	if($size > 10000000) //conditions for the file
// 	{
// 	die("Format is not allowed or file size is too big!");
// 	}
// 	
// else
// 	{

$location=$_FILES["image"]["name"];
$r = move_uploaded_file($_FILES["image"]["tmp_name"],"./uploads/" . $location);

$zip = new ZipArchive;
if ($zip->open("./uploads/".$location) === TRUE) {
    $zip->extractTo('./uploads/');
    $zip->close();
}

if(strlen($location) > 4 and substr($location, -4) == ".zip"){
    $location = substr($location, 0, -4);
}

$fname=$_POST['first_name'];
$lname=$_POST['last_name'];


$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO myshop_shelves (shelve_name, shelve_description, image_location)
VALUES ('$fname', '$lname', '$location')";
$conn->exec($sql);

// uploadToWoo($fname, $lname);
echo "<script>window.location='../../../../../wp-admin/edit.php'</script>";
// }
}
// }

function uploadToWoo($fname, $lname){      
    

    $objProduct = new WC_Product();
    $objProduct = new WC_Product_Variable();

    $objProduct->set_name($fname);
    $objProduct->set_status("publish");  // can be publish,draft or any wordpress post status
    $objProduct->set_catalog_visibility('visible'); // add the product visibility status
    $objProduct->set_description($lname);
    $objProduct->set_sku("product-sku"); //can be blank in case you don't have sku, but You can't add duplicate sku's
    $objProduct->set_price(10.55); // set product price
    $objProduct->set_regular_price(10.55); // set product regular price
    $objProduct->set_manage_stock(true); // true or false
    $objProduct->set_stock_quantity(10);
    $objProduct->set_stock_status('instock'); // in stock or out of stock value
    $objProduct->set_backorders('no');
    $objProduct->set_reviews_allowed(true);
    $objProduct->set_sold_individually(false);
    $objProduct->set_category_ids(array(31)); // array of category ids, You can get category id from WooCommerce Product Category Section of Wordpress Admin
    $product_id = $objProduct->save();
}
?>