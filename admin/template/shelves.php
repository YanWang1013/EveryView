
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
    @media (max-width: 768px) {
        #shelf-table td img{
            height: 30px;
        }
    }
    .file-upload {
        background-color: #ffffff;
        margin: 0 auto;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
        left: 0;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
        color: #ffffff;
        cursor: pointer;
    }
    .image-upload-wrap:hover h3{
        color: #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }
    #shelf-table td, #shelf-table th {
        vertical-align: middle;
        text-align: center;
    }

    .btn {
        text-transform: uppercase;
    }

    .btn-success {
        background: green;
        color: white;
        border: 1px solid green;
    }

    .btn-primary {
        background: #2415a6;
        color: black;
        border: 1px solid black;
    }

    .btn-error {
        background: red;
        color: white;
        border: 1px solid red;
    }

    .center {
        height: 350px;
        border-radius: 3px;
        box-shadow: 8px 10px 15px 0 rgba(0, 0, 0, 0.2);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        flex-direction: column;
    }

    .title {
        width: 100%;
        height: 50px;
        border-bottom: 1px solid #999;
        text-align: center;
    }

    h1 {
        font-size: 16px;
        font-weight: 300;
        color: #666;
    }

    .dropzone {
        width: 100px;
        height: 80px;
        border: 1px dashed #999;
        border-radius: 3px;
        text-align: center;
    }

    .upload-icon {
        margin: 25px 2px 2px 2px;
    }

    .upload-input {
        position: relative;
        top: -62px;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
    }

    .btn {
        /*background: darkmagenta;*/
        color: #fff;
        border-radius: 3px;
        border: 0;
        box-shadow: 0 3px 0 0 hotpink;
        transition: all 0.3s ease-in-out;
        font-size: 14px;
    }

    .panel {margin: 100px auto 40px; max-width: 500px; text-align: center;}
    .button_outer {background: #83ccd3; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
    .btn_upload {padding: 17px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
    .btn_upload input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
    .file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
    .file_uploading .btn_upload {display: none;}
    .processing_bar {position: absolute; left: 0; top: 0; width: 0; height: 100%; border-radius: 30px; background:#83ccd3; transition: 3s;}
    .file_uploading .processing_bar {width: 100%;}
    .success_box {display: none; width: 50px; height: 50px; position: relative;}
    .success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
    .file_uploaded .success_box {display: inline-block;}
    .file_uploaded {margin-top: 0; width: 50px; background:#83ccd3; height: 50px;}
    .uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
    .file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
    .file_remove:hover {background: #222; transition: .2s;}
    .uploaded_file_view img {max-width: 100%;}
    .uploaded_file_view.show {opacity: 1;}
    .error_msg {text-align: center; color: #f00}

</style>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo __( 'Shelves', 'myshop-shelves' ); ?></h1>
    <a href="#" class="page-title-action"><?php echo __( 'Add New', 'myshop-shelves' ); ?></a>
    <div class="row ">
        <table class="wp-list-table widefat fixed striped table-view-list posts" id="shelf-table">
            <thead>
            <tr>
                <th><?php echo __( 'Shelve Image', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Shelve Name', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Description', 'myshop-shelves' ); ?></th>
                <th><?php echo __( 'Action', 'myshop-shelves' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $result = $conn->prepare("SELECT * FROM myshop_shelves ORDER BY tbl_image_id ASC");
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $id = $row['tbl_image_id'];
                ?>
                <tr>
                    <td>
                        <?php if ($row['image_location'] != ""): ?>
                            <img src="<?php echo get_site_url() . '/' . $row['image_location']; ?>"
                                 height="100px" style="border:1px solid #333333;">
                        <?php else: ?>
                            <img src="./_custom/shelves/images/default.png" height="100px"
                                 style="border:1px solid #333333;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row ['shelve_name']; ?></td>
                    <td><?php echo $row ['shelve_description']; ?></td>
                    <td>
                        <!--
                         ========================================= UPDATE MODAL CONTENT =========================================
                         -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#updateModal<?php echo $row ['tbl_image_id']; ?>">
                            <?php echo __( 'Update', 'myshop-shelves' ); ?>
                        </button>
                        <div class="modal fade" id="updateModal<?php echo $row ['tbl_image_id']; ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel<?php echo $row ['tbl_image_id']; ?>"><?php echo __( 'Update Image', 'myshop-shelves' ); ?> <?php echo $row ['tbl_image_id']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="">
                                            <div class="file-upload">
                                                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?php echo __( 'Add Image', 'myshop-shelves' ); ?></button>

                                                <div class="image-upload-wrap">
                                                    <input id="upload-image-<?php echo $row ['tbl_image_id']; ?>" class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                                                    <div class="drag-text">
                                                        <h3><?php echo __( 'Drag and drop a file or select add Image', 'myshop-shelves' ); ?></h3>
                                                    </div>
                                                </div>
                                                <div class="file-upload-content">
                                                    <img class="file-upload-image" src="#" alt="your image" />
                                                    <div class="image-title-wrap">
                                                        <button type="button" onclick="removeUpload('<?php echo $row ['tbl_image_id']; ?>')" class="remove-image"><?php echo __( 'Remove', 'myshop-shelves' ); ?> <span class="image-title"><?php echo __( 'Uploaded Image', 'myshop-shelves' ); ?></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" >
                                            <?php echo __( 'Yes', 'myshop-shelves' ); ?>
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <?php echo __( 'No', 'myshop-shelves' ); ?>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--
                         ========================================= DELETE MODAL CONTENT =========================================
                         -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            <?php echo __( 'Delete', 'myshop-shelves' ); ?>
                        </button>
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo __( 'Delete Image', 'myshop-shelves' ); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h1><?php echo __( 'Are you sure to delete?', 'myshop-shelves' ); ?></h1>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" >
                                            <?php echo __( 'Yes', 'myshop-shelves' ); ?>
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                             <?php echo __( 'No', 'myshop-shelves' ); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--
                         ========================================= VIEW MODAL CONTENT =========================================
                         -->
                        <button class="btn btn-primary"><?php echo __( 'View', 'myshop-shelves' ); ?></button>
                    </td>
                </tr>
            <?php }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }
    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
</script>

