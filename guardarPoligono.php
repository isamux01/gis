<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include("inc/dbpsql.php");

if (isset($_GET['coordenada']))
        {
	$coordenada = $_GET['coordenada'];
	}

ECHO "Se guardo correctamente el polígono: ";
ECHO $coordenada;
ECHO "<br><br>";
	$id_poligono = 1;
	//Leaflet utiliza "lat, lon" y PostgreSQL utiliza "lon, lat", con ST_FlipCoordinates se cambia el orden.
	$queryinsertpoligono = "INSERT INTO poligonos (id_poligono, geom) VALUES ($id_poligono, ST_FlipCoordinates(ST_GeomFromText('POLYGON((".$coordenada."))', 4326)))";
	$queryinpol = pg_query($queryinsertpoligono);
?>
