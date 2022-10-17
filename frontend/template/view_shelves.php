<h2 class="mb-1"><?php echo __( 'Shelves', 'myshop-shelves' ); ?></h2>
<p><?php echo __( 'You can select product from shelve and add it to cart', 'myshop-shelves' ); ?></p>
<table class="table" id="shelf-table">
    <thead>
    <tr>
        <th><?php echo __( 'Shelve Image', 'myshop-shelves' ); ?></th>
        <th class="text-center"><?php echo __( 'Shelve Name', 'myshop-shelves' ); ?></th>
        <th class="text-center"><?php echo __( 'Description', 'myshop-shelves' ); ?>	</th>
        <th class="text-right"><?php echo __( 'Action', 'myshop-shelves' ); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0; $row = $result->fetch(); $i++) {
    $id = $row['tbl_image_id']; ?>
    <tr>
        <td style="">
            <?php if ($row['image_location'] != ""): ?>
                <img src="<?php echo get_site_url() . '/'  . $row['image_location']; ?>"
                     height="120" style="border:1px solid #333333; height: 120px;">
            <?php else: ?>
                <img src="<?php echo get_site_url()?>/images/default.png" height="120"
                     style="border:1px solid #333333; height: 120px!important">
            <?php endif; ?>
        </td>
        <td class="text-center"> <?php echo $row ['shelve_name']; ?></td>
        <td class="text-center"> <?php echo $row ['shelve_description']; ?></td>
        <td class="text-right">
            <?php $lang = wpml_get_current_language()?>
            <a href="<?php echo get_site_url(). '/shop-shelf/?shelve_id=' . $id. '&lang='.$lang; ?>" class="btn btn-primary">
                <?php echo __( 'Crop and Add to Cart', 'myshop-shelves' ); ?>
            </a>
        </td>
        <?php } ?>
    </tbody>
</table>