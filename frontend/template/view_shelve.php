<style>
    .container-fluid, .container-fluid .vc_section:not(.porto-inner-container) {
        padding-left: 0;
        padding-right: 0;
    }

    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }

    .row {
        margin-right: 0;
        margin-left: 0;
    }

    .map-top-button {
        background: rgba(0, 60, 136, .5);
        color: white;
        border: 3px solid rgba(255, 255, 255, .5);
        font-size: 14px;
        border-radius: 2px;
        cursor: pointer;
    }

    .map-top-button:hover {
        background: rgba(0, 60, 136, 1);
        border: 3px solid rgba(255, 255, 255, 1);
    }

    #slider {
        cursor: pointer;
    }

    #prev-shelf, #next-shelf {
        position: absolute;
        top: calc(50vh - 25px);
        width: 50px;
        height: 50px;
        background: rgba(0, 60, 136, .5);
        border-radius: 100px;
        border: 3px solid rgba(255, 255, 255, .5);
        cursor: pointer;
        text-align: center;
    }

    #prev-shelf:focus, #next-shelf:focus {
        outline: none;
    }

    #prev-shelf:hover, #next-shelf:hover {
        background: rgba(0, 60, 136, 1);
        border: 3px solid rgba(255, 255, 255, 1);
    }

    #prev-shelf i, #next-shelf i {
        color: #fff;
        font-size: 17px;
        margin-top: 13px;
    }

    #prev-shelf {
        left: 10px;
    }

    #next-shelf {
        right: 10px;
    }

    #header {
        background: rgba(255, 255, 255, .3);
    }

    .fixed-header #header .header-main .header-left {
        padding-top: 3px;
        padding-bottom: 3px;
    }

    .ol-zoom {
        top: 6em;
        left: 0.5em;
    }

    #header .logo {
        min-width: 50px;
    }

    #header .header-main .header-left, #header .header-main .header-center, #header .header-main .header-right, .fixed-header #header .header-main .header-left, .fixed-header #header .header-main .header-right, .fixed-header #header .header-main .header-center {
        padding-top: 2px;
        padding-bottom: 2px;
    }

    .bottom-tool {
        position: absolute;
        top: 5em;
        right: 0.5em;
        display: block;
        margin: 1px;
        padding: 0;
        color: #fff;
        font-size: 1.14em;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        line-height: .4em;
        background-color: rgba(0, 60, 136, .5);
        border-radius: 4px;
        border: 3px solid rgba(255, 255, 255, .5);
    }

    .bottom-tool button {
        display: block;
        margin: 1px;
        padding: 0;
        color: #fff;
        font-size: 1.14em;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        height: 1.375em;
        width: 1.375em;
        line-height: .4em;
        background-color: rgba(0, 60, 136, .5);
        border: none;
        opacity: 0.5;
    }

    .bottom-tool button:hover {
        opacity: 1;
    }

    .bottom-tool button.active {
        opacity: 1;
    }

</style>
<div class="row m-0 p-0">
    <div class="col-md-12 m-0 p-0" style="height: 100vh;">
    	<canvas style="width: 0px; height: 0px; visibility: hidden;"></canvas> <!-- entire area !-->
    	<canvas style="width: 0px; height: 0px; visibility: hidden;"></canvas> <!-- cropped area !-->
        <div id="map"></div>
    	
        <?php $lang = wpml_get_current_language()?>


        <a class="prev-shelf" id="prev-shelf" href="<?php echo get_site_url() ?>/shop-shelf/?shelve_id=19&lang=<?php echo $lang;?>">
            <i class="fa fa-fast-backward"></i>
        </a>
        <a class="next-shelf" id="next-shelf" href="<?php echo get_site_url() ?>/shop-shelf/?shelve_id=20&lang=<?php echo $lang;?>">
            <i class="fa fa-fast-forward"></i>
        </a>
    </div>
    <div class="bottom-tool">
        <div class="tools">
            <button id="rectSelector" class="active"><i class="fas fa-vector-square"></i></button>
            <button id="showSelector"><i class="far fa-eye"></i></button>
            <button id="searchSelector"><i class="fas fa-search"></i></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

    var imgSrcUrl = '<?php echo get_site_url() . $shelf["tile_source"]?>';
    var siteUrl = '<?php echo get_site_url()?>';
    var imageUrl = '<?php echo $shelf["image_location"]?>';
    var drawType = 'circle';
    var isLogin = true;
    
    jQuery(document).ready(function ($) {
        "use strict";
        if (typeof imgSrcUrl !== 'undefined') {
            var mapExtent = [0.00000000, -4000.00000000, 5500.00000000, 0.00000000];
            var mapMinZoom = 1;
            var mapMaxZoom = 6;
            var mapMaxResolution = 1.000000;
            var mapResolution = [];
            for (var z = 1; z <= mapMaxZoom; z++) {
                mapResolution.push(Math.pow(2, mapMaxZoom - z) * mapMaxResolution);
            }

            var mapTileGrid = new ol.tilegrid.TileGrid({
                extent: mapExtent,
                minZoom: mapMinZoom,
                resolutions: mapResolution,
                tileSize: [256, 256]
            });

            var img_url = imgSrcUrl + '/{z}/{x}/{y}.png';

            var layer = new ol.layer.Tile({
                source: new ol.source.XYZ({
                    projection: 'PIXELS',
                    tileGrid: mapTileGrid,
                    tilePixelRatio: 1.00000000,
                    url: img_url,
                })
            });

            var source = new ol.source.Vector({wrapX: false});

            var vector = new ol.layer.Vector({
                source: source,
                updateWhileInteracting: true,
            });


            var map = new ol.Map({
                layers: [layer, vector],
                target: 'map',
                view: new ol.View({
                    extent: mapExtent,
                })
            });

            map.getView().fit(mapExtent, map.getSize());
        }

        var hidden_data;
        const downloadCrop = function (p0, p1) {

            if((p0[0] - p1[0])*(p0[0] - p1[0])>10000){
            	
            	// Get canvas for cloning of entire map area
			    var mapCanvas = document.getElementsByTagName('canvas')[0];
			    
			    // Set canvas size equal to map size
			    var size = map.getSize();
			    mapCanvas.width = size[0];
			    mapCanvas.height = size[1];
			    var mapCtx = mapCanvas.getContext('2d');
			    
			    // Process all openlayer canvases
			    Array.prototype.forEach.call(
			      document.querySelectorAll('.ol-layer canvas'),
			      function (canvas) {
			        if (canvas.width > 0) {
			          var opacity = canvas.parentNode.style.opacity;
			          mapCtx.globalAlpha = opacity === '' ? 1 : Number(opacity);
			          
			          // This is very important, especially for mobile
			          var transform = canvas.style.transform;
			          // Get the transform parameters from the style's transform matrix
			          var matrix = transform
			            .match(/^matrix\(([^\(]*)\)$/)[1]
			            .split(',')
			            .map(Number);
			          // Apply the transform to the export map context
			          CanvasRenderingContext2D.prototype.setTransform.apply(
			            mapCtx,
			            matrix
			          );
			          
			          // Draw child-canvas to entire-area-canvas
			          mapCtx.drawImage(canvas, 0, 0);
			        } // if
			      } // func
			    ); // array
            	
            	// Now we are going to crop from entire area
            	// Cropped area
                var l = p0[0] < p1[0] ? p0[0] : p1[0];
                var t = p0[1] < p1[1] ? p0[1] : p1[1];
                var r = p0[0] > p1[0] ? p0[0] : p1[0];
                var b = p0[1] > p1[1] ? p0[1] : p1[1];
                
                if (l < 0) l = 0; else if (l > mapCanvas.width) l = mapCanvas.width;
                if (t < 0) t = 0; else if (t > mapCanvas.height) t = mapCanvas.height;
                if (r < 0) r = 0; else if (r > mapCanvas.width) r = mapCanvas.width;
                if (b < 0) b = 0; else if (b > mapCanvas.height) b = mapCanvas.height;
                
                var width = r - l;
                var height = b - t;
                
                // Get canvas for cropped area
                var croppedCanvas = document.getElementsByTagName('canvas')[1];
                croppedCanvas.width = width;
                croppedCanvas.height = height;
                var croppedCtx = croppedCanvas.getContext('2d');

				// Draw cropped area (from entire-area-canvas) to cropped-canvas
                croppedCtx.drawImage(
                    mapCanvas,
                    l,//Start Clipping
                    t,//Start Clipping
                    width,//Clipping Width
                    height,//Clipping Height
                    0,//Place X
                    0,//Place Y
                    croppedCanvas.width,//Place Width
                    croppedCanvas.height//Place Height
                );

				// This is needed only for circle region
				if (false) {
                	croppedCtx.globalCompositeOperation = 'destination-in';
                	croppedCtx.beginPath();
                	croppedCtx.fillRect(0, 0, width, width);
                	croppedCtx.closePath();
                	croppedCtx.fill();
                }
				
				// Convert to binary-png data (base64 format)
                hidden_data = croppedCanvas.toDataURL("image/png", 1).replace("image/png", "image/octet-stream");
                
                swal.fire({
                    title: 'האם להוסיף לסל הקניות את המוצר שבתמונה זו?',
                    html:"<img src='"+ hidden_data +"'/>",
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: `כן`,
                    cancelButtonText: `לא`, 
                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            if(isLogin){
                                $.ajax({
                                    type: 'POST',
                                    url: siteUrl + '/wp-admin/admin-ajax.php',
                                    data: {
                                        'action': 'shelf_add_to_cart',
                                        'imgBase64': hidden_data,
                                        'sid': imageUrl
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        var res = data.result;
                                        console.log(res);

                                        // Swal.fire({
                                        //     title: 'שוב האם להוסיף',
                                        //     text: "נוסף בהצלחה",
                                        //     icon: 'warning',
                                        //     showCancelButton: true,
                                        //     confirmButtonColor: '#3085d6',
                                        //     cancelButtonColor: '#d33',
                                        //     confirmButtonText: 'הוסף'
                                        // }).then((result) => {
                                           // if (result.isConfirmed) {
                                                $.ajax({
                                                    type: "POST",
                                                    url: siteUrl + '/?wc-ajax=add_to_cart',
                                                    data: {
                                                        "product_sku": "",
                                                        "product_id": res,
                                                        "quantity": 1
                                                    },
                                                    dataType: 'json',
                                                    success: function (data) {
                                                        for (const [key, value] of Object.entries(data.fragments)) {
                                                            $(key).replaceWith(value);
                                                        }
                                                        Swal.fire(
                                                            'המוצר התווסף לסל '
                                                        )
                                                    }
                                                })

                                            // } else {
                                            //     Swal.fire(
                                            //         'נוסף בהצלחה!',
                                            //         'אבל לא הוספת את זה על תיק הקניות שלך',
                                            //     )
                                            // }
                                        // })
                                    }
                                });
                            } else {
                                swal.fire("עליך להתחבר למערכת על מנת להזמין?");
                            }
                            // Make a download link
                            // var downloadAnchor = document.createElement('a');
                            // downloadAnchor.setAttribute('download', 'Crop.png');
                            // downloadAnchor.setAttribute('href', hidden_data);
                            // downloadAnchor.setAttribute('id', 'download-image');
                            // document.body.appendChild(downloadAnchor);
                            // downloadAnchor.click();
                            // document.body.removeChild(downloadAnchor);
                            // alert("Successfully saved!");
                        } else {
                            // noam no need of this
                            // Swal.fire('השינויים לא נשמרים', '', 'info')
                        }
                    });

            }

        };

        map.getView().fit(mapExtent, map.getSize());

        var pressTimer = 0;
        var radius = 10;
        var a0 = [0, 0];
        var a1 = [0, 0];
        var a2 = [0, 0];
        var a3 = [0, 0];

        var circle = new ol.geom.Circle([0, 0], 0, 'XY');
        var rect = new ol.geom.Polygon([[a0, a1, a2, a3, a0]], 'XYZM');
        var pointer = new ol.geom.Point([0,0], 'XY');
        var doDownload;
        var p0;
        var p1;
        var prevEvent;

        source.addFeature(new ol.Feature({geometry: circle}));
        source.addFeature(new ol.Feature({geometry: rect}));
        source.addFeature(new ol.Feature({geometry: pointer}));

        map.addInteraction(new ol.interaction.Interaction({
            handleEvent: function (e) {
                if (e.type === 'pointerdown') {
                	console.log('pointerdown');
                    prevEvent = e.pixel;
                    if (pressTimer !== 0) {
                        clearInterval(pressTimer);
                        pressTimer = 0;
                    }
                    var center = map.getCoordinateFromPixel(e.pixel);
                    a0 = [center[0] + radius, center[1] + radius];
                    a1 = [center[0] - radius, center[1] + radius];
                    a2 = [center[0] - radius, center[1] - radius];
                    a3 = [center[0] + radius, center[1] - radius];
                    rect.setCoordinates([[a0, a1, a2, a3, a0]]);
                    pointer.setCoordinates(center);
                    vector.setVisible(true);
                    pressTimer = setInterval(function () {
                        radius = radius + map.getView().getResolution();
                        a0 = [center[0] + radius, center[1] + radius];
                        a1 = [center[0] - radius, center[1] + radius];
                        a2 = [center[0] - radius, center[1] - radius];
                        a3 = [center[0] + radius, center[1] - radius];
                        rect.setCoordinates([[a0, a1, a2, a3, a0]]);
                    }, 10);
                }
                else if (e.type === 'pointerup') {
                	console.log('pointerup');
                    if (pressTimer !== 0) {
						
						// Clear timer and remove rectangle
                    	clearInterval(pressTimer);
                    	pressTimer = 0;
                    	rect.setCoordinates([[[0, 0], [0, 0], [0, 0], [0, 0], [0, 0]]]);

						// Set one-time-trigger (after map-rendering is completed)
						map.once('rendercomplete', function () {

	                        p0 = map.getPixelFromCoordinate(a2);
	                        p1 = map.getPixelFromCoordinate(a0);
	                        downloadCrop(p0, p1);

							// Reset (hide vector layer and reset radius)
	                        vector.setVisible(false);
	                        radius = 0;
						});
                    	
                    	// Re-render map 
                    	map.renderSync(); // this will fire above trigger
                    }
                }
                return 1;
            }
        }));


        $("#rectSelector").on('click', function () {
            // drawType = 'rect';
            $("#rectSelector").addClass('active');
            $("#showSelector").removeClass('active');
            $("#searchSelector").removeClass('active');
        });
        $("#showSelector").on('click', function () {
            // drawType = 'rect';
            $("#rectSelector").removeClass('active');
            $("#showSelector").addClass('active');
            $("#searchSelector").removeClass('active');
        });
        $("#searchSelector").on('click', function () {
            // drawType = 'rect';
            $("#rectSelector").removeClass('active');
            $("#showSelector").removeClass('active');
            $("#searchSelector").addClass('active');
        });


    })
</script>
