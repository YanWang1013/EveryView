<?php
require_once('db.php');

$s_id=$_GET['shelve_id'];

$result = $conn->prepare("SELECT * FROM myshop_shelves WHERE tbl_image_id = '{$s_id}'");
$result->execute();
$row = $result->fetch();
$img_src=$row['image_location'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Select Product</title>
<meta charset="utf-8">
<meta http-equiv="imagetoolbar" content="no"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<style type="text/css">
html, body { margin:0; padding: 0; height: 100%; width: 100%; }
body { width:100%; height:100%; background: #ffffff; }
#map { position: absolute; height: 100%; width: 100%; background-color: #FFFFFF; }
#slider { position: absolute; top: 10px; right: 10px; }
</style>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">

<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,fetch,Function.prototype.bind,es5&flags=always,gated&unknown=polyfill" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.3.1/build/ol.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.3.1/css/ol.css">

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>

</head>
<body>


<div id="map">
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">

<h3 id="myModalLabel">Add Product</h3>
</div>
<div class="modal-body">
<table class="table1">
	<tr>
		<td><label style="color:#3a87ad; font-size:18px;">Product Name</label></td>
		<td width="30"></td>
		<td><input type="text" id="textName" placeholder="Product Name" required /></td>
	</tr>
	<tr>
		<td><label style="color:#3a87ad; font-size:18px;">Description</label></td>
		<td width="30"></td>
		<td><input type="text" id="textDescription" placeholder="Description" required /></td>
  </tr>
  <tr>
		<td><label style="color:#3a87ad; font-size:18px;">Price</label></td>
		<td width="30"></td>
		<td><input type="number" id="textPrice" required /></td>
	</tr>
</table>
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="btnAddProduct" class="btn btn-primary">Add</button>
    </div>
</div>		




<input id="slider" type="range" min="0" max="1" step="0.1" value="1" oninput="layer.setOpacity(this.value)">

<script type="text/javascript">
var mapExtent = [0.00000000, -2329.00000000, 4140.00000000, 0.00000000];
var tileExtent = [0.00000000, -2329.00000000, 4140.00000000, 0.00000000];
var projection = new ol.proj.Projection({
  code: 'xkcd-image',
  units: 'pixels',
  extent: mapExtent
});

var mapMinZoom = 0;
var mapMaxZoom = 5;
var mapMaxResolution = 1.00000000;

var mapResolutions = [];
for (var z = 0; z <= mapMaxZoom; z++) {
  mapResolutions.push(Math.pow(2, mapMaxZoom - z) * mapMaxResolution);
}

var mapTileGrid = new ol.tilegrid.TileGrid({
  extent: mapExtent,
  minZoom: mapMinZoom,
  resolutions: mapResolutions
});

var layer = new ol.layer.Tile({
  source: new ol.source.XYZ({
  //  attributions: 'ship; Rendered with <a href="https://www.maptiler.com/desktop/">MapTiler Desktop</a>',
    projection: 'PIXELS',
    tileGrid: mapTileGrid,
    tilePixelRatio: 1.00000000,
    url: "uploads/<?php echo $img_src;?>/{z}/{x}/{y}.png",
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
  //  projection: ol.proj.get('PIXELS'),
    extent: mapExtent,
  //  maxResolution: mapTileGrid.getResolution(mapMinZoom)
    
  })
});

/*
layers = new ol.layer.Image({
    source: new ol.source.ImageStatic({
      attributions: '© <a href="http://xkcd.com/license.html">xkcd</a>',
      url: 'uploads/',
      projection: projection,
      imageExtent: mapExtent
    })
});

var source = new ol.source.Vector({wrapX: false});

var vector = new ol.layer.Vector({
source: source
});

var map = new ol.Map({
    layers: [layers, vector],  
    target: 'map',
  
    view: new ol.View({
      projection: projection,
      center: ol.extent.getCenter(mapExtent),
      zoom: 2,
      maxZoom: 8
  })
});
*/

var mapCanvas = document.getElementsByTagName('canvas')[0];

map.getView().fit(mapExtent, map.getSize());

var pressTimer = 0;
var circle = new ol.geom.Circle([0, 0], 0, 'XY');
source.addFeature(new ol.Feature({geometry: circle}));

var hidden_data;

$("#btnAddProduct").click(function() {
  var tname = $('#textName').val();
  $.ajax({
    type : 'POST',
    url : 'addAutoProduct.php',
    data: {
      imgBase64: hidden_data,
      pname : tname,
      pdescription : $('#textDescription').val(),
      pprice : $('#textPrice').val(),
    },
    dataType: 'json',
    success : function(data){
      alert ("Successfully saved!");
      $("#myModal").modal("hide");
    }
  });
});

var downloadCrop = function(p0, p1) {

  var l = p0[0] < p1[0] ? p0[0] : p1[0];
  var t = p0[1] < p1[1] ? p0[1] : p1[1];
  var r = p0[0] > p1[0] ? p0[0] : p1[0];
  var b = p0[1] > p1[1] ? p0[1] : p1[1];
  var width = r - l;
  var height = b - t;
  var hidden_canv = document.createElement('canvas');
  hidden_canv.width = width;
  hidden_canv.height = height;

  //Draw the data you want to download to the hidden canvas
  var hidden_ctx = hidden_canv.getContext('2d');
  hidden_ctx.drawImage(
      mapCanvas, 
      l,//Start Clipping
      t,//Start Clipping
      width,//Clipping Width
      height,//Clipping Height
      0,//Place X
      0,//Place Y
      hidden_canv.width,//Place Width
      hidden_canv.height//Place Height
  );

  hidden_ctx.globalCompositeOperation='destination-in';
  hidden_ctx.beginPath();
  hidden_ctx.arc(width / 2, height / 2, width / 2,0,Math.PI*2);
  hidden_ctx.closePath();
  hidden_ctx.fill();

  //Create a download URL for the data

  hidden_data = hidden_canv.toDataURL("image/png", 1).replace("image/png", "image/octet-stream"); 
  $("#myModal").modal("toggle");
   
  return;
  //Make a download link
  var downloadAnchor = document.createElement('a');
  downloadAnchor.setAttribute('download', 'Crop.png');
  downloadAnchor.setAttribute('href', hidden_data);
  downloadAnchor.setAttribute('id', 'download-image');
  document.body.appendChild(downloadAnchor);
  downloadAnchor.click();
  document.body.removeChild(downloadAnchor);
  alert ("Successfully saved!");
};

map.addInteraction(new ol.interaction.Interaction({handleEvent:function(e) {
	
	if (e.type == 'pointerdown') {
		if (pressTimer != 0) {
			clearInterval(pressTimer);
			pressTimer = 0;
		}
		circle.setCenter(map.getCoordinateFromPixel(e.pixel));
		vector.setVisible(true);
	    pressTimer = setInterval(function() {
	      if (circle.getRadius() < map.getView().getResolution() * 200)
	        circle.setRadius(circle.getRadius() + map.getView().getResolution() * 2);
	    }, 10);
	}
	else if (e.type == 'pointerup') {
		if (pressTimer != 0) {
			clearInterval(pressTimer);
			pressTimer = 0;
			var doDownload = confirm("Do you want to add this to product list?");
			var p0 = map.getPixelFromCoordinate([circle.getCenter()[0] - circle.getRadius(), circle.getCenter()[1] - circle.getRadius()]);
			var p1 = map.getPixelFromCoordinate([circle.getCenter()[0] + circle.getRadius(), circle.getCenter()[1] + circle.getRadius()]);
			circle.setRadius(0);
			vector.setVisible(false);
			map.renderSync();
			if (doDownload)
		    	downloadCrop(p0, p1);
		}
	}
	else {
		if (pressTimer != 0) {
			clearInterval(pressTimer);
			pressTimer = 0;
			circle.setRadius(0);
			vector.setVisible(false);
		}
	}
		
	return 1;
}}));

</script>
</body>
</html>
