<?php
require_once('db.php');
require_once('./../../../wp-load.php');

$get_id=$_GET['tbl_image_id'];

// sql to delete a record
$sql = "Delete from myshop_shelves where tbl_image_id = '$get_id'";

// use exec() because no results are returned
$conn->exec($sql);
// header('location:index.php');

echo "<script>window.location='../../../../../wp-admin/edit.php'</script>";
?>