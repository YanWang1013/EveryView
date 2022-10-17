jQuery(document).ready(function ($) {
    "use strict";
    if (typeof imgSrcUrl !== 'undefined') {

        var mapExtent = [0.00000000, -2329.00000000, 4140.00000000, 0.00000000];

        var mapMinZoom = 1;
        var mapMaxZoom = 6;
        var mapMaxResolution = 1.00000000;

        var mapResolutions = [];
        for (var z = 0; z <= mapMaxZoom; z++) {
            mapResolutions.push(Math.pow(2, mapMaxZoom - z) * mapMaxResolution);
        }

        var mapTileGrid = new ol.tilegrid.TileGrid({
            extent: mapExtent,
            minZoom: mapMinZoom,
            resolutions: mapResolutions,
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
            source: source
        });

        var map = new ol.Map({
            layers: [layer, vector],
            target: 'map',
            view: new ol.View({
                extent: mapExtent,
            })
        });

        map.getView().fit(mapExtent, map.getSize());

        var pressTimer = 0;
        const circle = new ol.geom.Circle([0, 0], 0, 'XY');
        source.addFeature(new ol.Feature({geometry: circle}));

        var hidden_data;

        const downloadCrop = function (p0, p1) {
            var mapCanvas = document.getElementsByTagName('canvas')[0];

            var l = p0[0] < p1[0] ? p0[0] : p1[0];
            var t = p0[1] < p1[1] ? p0[1] : p1[1];
            var r = p0[0] > p1[0] ? p0[0] : p1[0];
            var b = p0[1] > p1[1] ? p0[1] : p1[1];
            var width = r - l;
            var height = b - t;
            var hidden_canvas = document.createElement('canvas');
            hidden_canvas.width = width;
            hidden_canvas.height = height;

            var hidden_ctx = hidden_canvas.getContext('2d');

            hidden_ctx.drawImage(
                mapCanvas,
                l,//Start Clipping
                t,//Start Clipping
                width,//Clipping Width
                height,//Clipping Height
                0,//Place X
                0,//Place Y
                hidden_canvas.width,//Place Width
                hidden_canvas.height//Place Height
            );

            hidden_ctx.globalCompositeOperation = 'destination-in';
            hidden_ctx.beginPath();
            hidden_ctx.arc(width / 2, height / 2, width / 2, 0, Math.PI * 2);
            hidden_ctx.closePath();
            hidden_ctx.fill();

            hidden_data = hidden_canvas.toDataURL("image/png", 1).replace("image/png", "image/octet-stream");

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
                    alert("Successfully Added");
                    $.get(siteUrl + '/?post_type=product&add-to-cart=' + res, function () {
                    });
                }
            });
            //Make a download link

            // var downloadAnchor = document.createElement('a');
            // downloadAnchor.setAttribute('download', 'Crop.png');
            // downloadAnchor.setAttribute('href', hidden_data);
            // downloadAnchor.setAttribute('id', 'download-image');
            // document.body.appendChild(downloadAnchor);
            // downloadAnchor.click();
            // document.body.removeChild(downloadAnchor);
            // alert("Successfully saved!");
        };

        var prevEvent;
        var flag = false;

        map.addInteraction(new ol.interaction.Interaction({
            handleEvent: function (e) {
                if (e.type === 'pointerdown' || e.type === 'mousedown') {
                    prevEvent = e.pixel;
                    flag = true;
                }
                else if (e.type === 'pointerup' || e.type === 'mouseup') {
                    if (pressTimer !== 0) {

                        flag = false;
                        clearInterval(pressTimer);
                        pressTimer = 0;

                        var p0 = map.getPixelFromCoordinate([circle.getCenter()[0] - circle.getRadius(), circle.getCenter()[1] - circle.getRadius()]);
                        var p1 = map.getPixelFromCoordinate([circle.getCenter()[0] + circle.getRadius(), circle.getCenter()[1] + circle.getRadius()]);
                        if (circle.getRadius() > 40) {
                            var doDownload = confirm("Do you want to add this to Cart?");
                            circle.setRadius(0);
                            vector.setVisible(false);
                            map.renderSync();
                            if (doDownload)
                                downloadCrop(p0, p1);
                        }
                        circle.setRadius(0);
                        vector.setVisible(false);

                    }
                }
                else {
                    if (pressTimer !== 0) {
                        if ((prevEvent[0] - e.pixel[0]) * (prevEvent[0] - e.pixel[0]) > 4000 || (prevEvent[1] - e.pixel[1]) * (prevEvent[1] - e.pixel[1]) > 4000) {
                            clearInterval(pressTimer);
                            pressTimer = 0;
                            circle.setRadius(0);
                            vector.setVisible(false);
                            flag = false;
                        }
                    }
                }
                if (flag === true) {
                    if (pressTimer !== 0) {
                        clearInterval(pressTimer);
                        pressTimer = 0;
                    }
                    circle.setCenter(map.getCoordinateFromPixel(e.pixel));
                    vector.setVisible(true);
                    pressTimer = setInterval(function () {
                        if (circle.getRadius() < map.getView().getResolution() * 200)
                            circle.setRadius(circle.getRadius() + map.getView().getResolution() * 2);
                    }, 10);
                }
                return 1;
            }
        }));

        $('#slider').on('change', function () {
            console.log(this.value);
            layer.setOpacity(this.value);
        });
        }
    }
);