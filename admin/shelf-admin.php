<?php
class ShopShelveAdmin
{
    public function __construct()
    {
        require('shelves.php');
    }

    public function index()
    {

    }
}

$shopShelfAdmin = new ShopShelveAdmin();
add_action('shop_shelf_admin', $shopShelfAdmin);