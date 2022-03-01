<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include("inc/dbpsql.php");

if (isset($_GET['coordenada']))
        {
	$coordenada = $_GET['coordenada'];
	}

ECHO "Se guardo correctamente la línea: ";
ECHO $coordenada;
ECHO "<br><br>";
	$id_linea = 1;
	//Leaflet utiliza "lat, lon" y PostgreSQL utiliza "lon, lat", con ST_FlipCoordinates cambiamos el orden.
	$queryinsertlinea = "INSERT INTO lineas (id_linea, geom) VALUES ($id_linea, ST_FlipCoordinates(ST_GeomFromText('LINESTRING(".$coordenada.")', 4326)))";
	$queryinli = pg_query($queryinsertlinea);
?>
