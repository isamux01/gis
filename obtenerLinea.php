<!DOCTYPE html>
<html>
<head>
    <title>Obtener Linea</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script src="libs/leaflet-src.js"></script>
    <link rel="stylesheet" href="libs/leaflet.css"/>

    <script src="src/Leaflet.draw.js"></script>
    <script src="src/Leaflet.Draw.Event.js"></script>
    <link rel="stylesheet" href="src/leaflet.draw.css"/>

    <script src="src/Toolbar.js"></script>
    <script src="src/Tooltip.js"></script>

    <script src="src/ext/GeometryUtil.js"></script>
    <script src="src/ext/LatLngUtil.js"></script>
    <script src="src/ext/LineUtil.Intersect.js"></script>
    <script src="src/ext/Polygon.Intersect.js"></script>
    <script src="src/ext/Polyline.Intersect.js"></script>
    <script src="src/ext/TouchEvents.js"></script>

    <script src="src/draw/DrawToolbar.js"></script>
    <script src="src/draw/handler/Draw.Feature.js"></script>
    <script src="src/draw/handler/Draw.SimpleShape.js"></script>
    <script src="src/draw/handler/Draw.Polyline.js"></script>
    <script src="src/draw/handler/Draw.Marker.js"></script>
    <script src="src/draw/handler/Draw.Circle.js"></script>
    <script src="src/draw/handler/Draw.CircleMarker.js"></script>
    <script src="src/draw/handler/Draw.Polygon.js"></script>
    <script src="src/draw/handler/Draw.Rectangle.js"></script>


    <script src="src/edit/EditToolbar.js"></script>
    <script src="src/edit/handler/EditToolbar.Edit.js"></script>
    <script src="src/edit/handler/EditToolbar.Delete.js"></script>

    <script src="src/Control.Draw.js"></script>

    <script src="src/edit/handler/Edit.Poly.js"></script>
    <script src="src/edit/handler/Edit.SimpleShape.js"></script>
    <script src="src/edit/handler/Edit.Rectangle.js"></script>
    <script src="src/edit/handler/Edit.Marker.js"></script>
    <script src="src/edit/handler/Edit.CircleMarker.js"></script>
    <script src="src/edit/handler/Edit.Circle.js"></script>
</head>
<body>

<center>
	<section class="wrapper style5">
		<div class="inner">

		<?PHP 
		ECHO "<h2>Obtener L??nea</h2>";
		ECHO "Una forma simple de obtener una l??nea de un mapa y guardarla en la base de datos PostgreSQL, utilizando las herramientas de LeafletDraw http://leaflet.github.io/Leaflet.draw/docs/leaflet-draw-latest.html";
		ECHO "<form action=\"guardarLinea.php\" method=\"GET\">";
			ECHO "<input type=\"hidden\" id=\"coordenada\" name=\"coordenada\">";
			ECHO "<div class=\"inner\">";
		ECHO "<br>";
		ECHO "<div id=\"map\" style=\"height: 400px; border: 1px solid #ccc\"></div>";

		ECHO "<section class=\"wrapper style2\">";
		ECHO "<input type=\"submit\" value=\"Guardar L??nea\">";
		ECHO "</form>";
        	ECHO "</div>";
        	ECHO "</section>";
	ECHO "</section>";
ECHO "</center>";
?>

<script>
//Mapa centrado en la CDMX
var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
	osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a>',
        osm = L.tileLayer(osmUrl, { maxZoom: 22, attribution: osmAttrib }),
	map = new L.Map('map', { center: new L.LatLng(19.432866537316112, -99.13318040026746), zoom: 15 }),
    	drawnItems = L.featureGroup();
    map.addLayer(drawnItems);

    L.control.layers({
        'Mapa OSM': osm.addTo(map)}, {'Puntos': drawnItems }, { position: 'topright', collapsed: false}).addTo(map);

//Herramientas de dibujo
    var drawControlFull = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                showArea: true
    	    },
	    marker: false,
	    polyline: true,
	    polygon: false,
	    circle: false,
	    circlemarker: false,
	    rectangle: false
        }
    });

    var drawControlEditOnly = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
            poly: {
                allowIntersection: false
            }
        },
	draw: false
    });
//A??ade las herramientas al mapa    
map.addControl(drawControlFull);

map.on('draw:created', function (e) {
    var type = e.layerType,
        layer = e.layer;

	if(type == 'polyline')
		{
		let obtPuntosLinea = layer.getLatLngs();
		//Obtiene las coordenadas de los puntos de la linea en el mapa
		let puntosLinea = obtPuntosLinea.toString();
		//Convierte a cadena de caracteres con este formato "LatLng(19.437902, -99.13916),LatLng(19.436081, -99.135381)"
		//Para obtener solo los puntos se va a remover el texto innecesario. 
		let removerLatLng = puntosLinea.replace(/LatLng\(/g, ''); 
		//Remueve la primera parte del texto quedando "19.437902, -99.13916),19.436081, -99.135381)"
		let removerComas = removerLatLng.replace(/\,/g, '');
		//Remueve las comas quedando "19.437902 -99.13916)19.436081 -99.135381)"
		var cambiarParentesis = removerComas.replace(/\)/g, ',');
		//Cambia los parentesis por comas quedando "19.437902 -99.13916,19.436081 -99.135381,"
		var linea = cambiarParentesis.substring(0, cambiarParentesis.length - 1);
		//Remueve el ultimo caracter del string, en este caso la coma al final.
                document.getElementById('coordenada').value = linea;
		//Guarda los puntos de la linea en la variable coordenada.
		}


        drawnItems.addLayer(layer);
        map.removeControl(drawControlFull);
	map.addControl(drawControlEditOnly);
    });

map.on("draw:deleted", function(e) {
        map.removeControl(drawControlEditOnly);
        map.addControl(drawControlFull);
});
</script>
	<script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/skel.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>

</body>
</html>
