<?php
//Conexion a la base de datos 
//Cambiar host, user y password por los correspondientes
$conn_string = "host=localhost dbname=geo user=daniel  password=daniel01";
$dbconn = pg_connect($conn_string) or die("Error");

return $dbconn;

pg_close($conn_string);
?>
