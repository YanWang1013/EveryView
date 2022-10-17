<?php
global $wpdb;

$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inhe_cart_history WHERE status = 0", OBJECT);
function minimizeString($string)
{
    if (strlen($string)> 50){
        return  str_split($string, 50)[0]. ' ...';
    } else {
        return $string;
    }

}
?>
<link type="text/css" rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript" rel="script"></script>

<input type="hidden" id="admin_url" value="https://localhost/myshop1.0/wp-admin/">
<div class="wrap">
    <h1><?php echo __( 'Customer Messages', 'myshop-shelves' ); ?></h1>
    <div class="table-responsive">
        <table id="messagesTable" class="display table ">
            <thead>
            <tr>
                <th><?php echo __( 'id', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Message', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Products', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'User', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Status', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Action', 'myshop-shelves' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $result):?>
            <tr>
                <td><?php echo $result->id;?></td>
                <td><?php echo minimizeString($result->message);?></td>
                <td>
                    <?php
                        $products = json_decode($result->products);
                        foreach ( $products as $product){
                            ?>
                            <span><?php echo $product->id;?>, </span>
                            <?php
                        }
                    ?>
                </td>
                <td><?php
                    $the_user = get_user_by( 'id', $result->user_id );
                    echo $the_user->user_nicename;
                ?></td>
                <td><?php echo $result->status;?></td>
                <td>
                    <!-- Large modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewModal<?php echo $result->id;?>">View</button>
                    <div class="modal fade bd-example-modal-lg" id="viewModal<?php echo $result->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo __( 'USER: ', 'myshop-shelves' ); ?> <?php echo $the_user->user_nicename;?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <div>
                                            <h5 class="text-uppercase"><?php echo __( 'Message', 'myshop-shelves' ); ?></h5>
                                        </div>
                                        <div class="card card-body" style="max-width: none;">
                                            <?php echo $result->message;?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row product-area">
                                            <?php
                                            $products = json_decode($result->products);
                                            foreach ( $products as $product){
                                               $product = wc_get_product($product->id);
//                                               print_r($product);
                                               ?>
                                                <div class="product-item">
                                                    <div class="product-image">
                                                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );?>
                                                        <img src="<?php  echo $image[0]; ?>">
                                                    </div>
                                                    <div class="product-title">
                                                        <a href="<?php echo get_admin_url();?>/post.php?post=<?php echo $product->get_id();?>&action=edit&lang=<?php echo wpml_get_current_language()?>">
                                                            <?php echo $product->get_name();?>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        $<?php echo $product->get_price();?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo __( 'Close', 'myshop-shelves' ); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
</div>

<script>
    jQuery(document).ready( function ($) {
        $('#messagesTable').DataTable({
            responsive: true
        });
    } );
</script>


<style>
    .dataTables_wrapper .dataTables_length select{
        width: 50px;
    }
    .product-area{
        justify-content: center;
        padding: 22px;
    }
    .product-item{
        width: 150px;
        text-align: center;
        float: left;
        border: 1px solid #ddd;
        margin: 2px;
        border-radius: 8px;
        padding: 10px!important;
    }
    .product-image img{
        width: 100px;
    }
    .product-title a{
        font-size: 16px;
        font-weight: 500;
        line-height: 1.1;
        color: black;
    }
@media(max-width: 768px){
.modal-backdrop.show{
z-index: -1!important;
}
}
</style>


