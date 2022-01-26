<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include("inc/dbpsql.php");

if (isset($_GET['coordenada']))
        {
	$coordenada = $_GET['coordenada'];
	}

ECHO "Se guardo la coordenada: ";
ECHO $coordenada;
ECHO "<br><br>";
	$id_punto = 1;
	//Leaflet utiliza "lat, lon" y PostgreSQL utiliza "lon, lat", con ST_FlipCoordinates cambiamos el orden.
	$queryinsertpunto = "INSERT INTO puntos (id_punto, geom) VALUES ($id_punto, ST_FlipCoordinates(ST_GeomFromText('POINT(".$coordenada.")', 4326)))";
	$queryinpunto = pg_query($queryinsertpunto);
?>
