<?php
// conexion a la base de datos
// estos datos se cambian segun el hosting

$host = "sql203.infinityfree.com";     // servidor de mysql
$user = "if0_42307845";               // usuario de mysql
$password = "31575302Lm";             // contrasena de mysql
$database = "if0_42307845_embotelladora_thomsom";  // nombre de la base de datos

$conn = mysqli_connect($host, $user, $password, $database);
// verifica si la conexion fallo
if (!$conn) {
    die("error de conexion: ". mysqli_connect_error());
}
// establece la codificacion a utf8 para caracteres especiales
mysqli_set_charset($conn, "utf8");
?>
