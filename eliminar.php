<?php
include('conexion.php');  // trae la conexion a la base de datos

// verifica si se recibio un id por la url
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];  // convierte el id a numero para seguridad
    // elimina el registro de llenado con ese id
    $sql_borrar = "DELETE FROM llenados WHERE id_llenados = '$id'";
    if (mysqli_query($conn, $sql_borrar)) {
        // si se elimino correctamente, redirige al historial
        header("Location: historial.php");
        exit();
    } else {
        // muestra el error si la consulta fallo
        echo "error en la consulta: " . mysqli_error($conn);
    }
} else {
    // si no llego id valido, muestra mensaje
    echo "error: no se recibio un id valido. el id recibido fue: " . (isset($_GET['id']) ? $_GET['id'] : "nada");
    echo "<br><a href='historial.php'>volver al historial</a>";
}
?>
