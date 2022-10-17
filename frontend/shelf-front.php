<?php

class ShelfFront
{
    public function __construct()
    {
        $this->conn = new PDO('mysql:host=localhost; dbname=everyvie_db','everyvie_user', 'zuj~ZLZvQ,L{');
    }

    public function processShortCode()
    {
        $result = $this->conn->prepare("SELECT * FROM myshop_shelves ORDER BY tbl_image_id ASC");
        $result->execute();
        require_once ('template/view_shelves.php');
    }

    public function processShelfShortCode()
    {
        if(isset($_GET['shelve_id']))
        {
            $id = $_GET['shelve_id'];
            $result = $this->conn->prepare("SELECT * FROM myshop_shelves WHERE tbl_image_id = ".$id);
            $result->execute();
            $shelf = $result->fetch();
            require('template/view_shelve.php');
        } else {
            $result = $this->conn->prepare("SELECT * FROM myshop_shelves WHERE tbl_image_id = 19");
            $result->execute();
            $shelf = $result->fetch();
            require('template/view_shelve.php');
        }
    }
}

$MyShopShelfFront = new ShelfFront();
add_shortcode('shelf-shop', array($MyShopShelfFront, 'processShortCode'));
add_shortcode('shelf-shop-content', array($MyShopShelfFront, 'processShelfShortCode'));
