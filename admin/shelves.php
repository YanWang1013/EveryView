<?php
function my_admin_menu()
{
    add_menu_page(
        __('Shelf page', 'shelf-plugin'),
        __('SHELVES', 'shelf-plugin'),
        'manage_options',
        'shelf-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        3
    );

    add_submenu_page(
        'shelf-page',
        'Customer Messages',
        'MESSAGES',
        'manage_options',
        'shelf-messages', 'messagePage', 4);
}

add_action('admin_menu', 'my_admin_menu');

function my_admin_page_contents()
{
    $conn =  new PDO('mysql:host=localhost; dbname=everyvie_db','everyvie_user', 'zuj~ZLZvQ,L{');
    require('template/shelves.php');
}

function messagePage()
{
    require('template/messages.php');
}

