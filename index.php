<?php
// oculta los errores de php en pantalla (modo produccion)
ini_set('display_errors', 0);
error_reporting(E_ALL);

include('conexion.php');  // trae la conexion a la base de datos

// si el formulario se envio por metodo post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // valida que el campo nombre no este vacio
if (empty($_POST['nombre'])) {
    echo "<script>
            alert('atencion! el campo nombre es obligatorio.');
            window.history.back();
          </script>";
    exit();
}

// valida que el campo cantidad no este vacio
if (empty($_POST['cantidad_botellones'])) {
    echo "<script>
            alert('atencion! el campo cantidad de botellones es obligatorio.');
            window.history.back();
          </script>";
    exit();
}
    // limpia los datos para evitar inyeccion sql
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $cantidadBotellones = (int)$_POST['cantidad_botellones'];
    
    // busca si el cliente ya existe en la base de datos
    $query = mysqli_query($conn, "SELECT id_cliente FROM clientes WHERE nombre = '$nombre'");

    if (mysqli_num_rows($query) > 0) {
        // si existe, obtiene su id
        $fila = mysqli_fetch_assoc($query);
        $cliente_id = $fila['id_cliente'];
    } else {
        // si no existe, lo crea con cedula por defecto
        mysqli_query($conn, "INSERT INTO clientes (nombre, cedula_rif) VALUES ('$nombre', 'N/A')");
        $cliente_id = mysqli_insert_id($conn);
    }

    // inserta el registro de llenado en la tabla llenados
    if (mysqli_query($conn, "INSERT INTO llenados (cliente_id, cantidad_botellones) VALUES ('$cliente_id', '$cantidadBotellones')")) {
        // si se guardo correctamente, muestra mensaje y redirige
        echo "<script>
                alert('registro exitoso para " . htmlspecialchars($nombre) . "!');
                window.location.href = 'principal.php';
              </script>";
    } else {
        // si hubo error en la base de datos, lo muestra
        echo "<script>
                alert('error en la base de datos: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
    
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Thomsom</title>
    <link rel="stylesheet" href="estilosc/estilos.css?v=1.1">
</head>
<body>
<!-- boton para volver al panel principal -->
<div class="contenedor-volver">
    <button class="boton-volver" onclick="window.location.href='principal.php';">
        ← volver al panel
    </button>
</div>

<!-- titulo principal de la pagina -->
    <h1 class="titulo-principal">embotelladora thomsom</h1>

<div class="contenedor-recuadro-fondo">
    <!-- contenedor del formulario de registro -->
    <div class="contenedor-principal">
        <img src="imagenes/Alogo.png" class="logo-fondo">
        <div class="formulario-encima">
            <h2 class="banda-superior">registro de llenado</h2>
            <form action="index.php" method="POST">
                <label>nombre:</label>
                <input type="text" name="nombre" class="input-campo" required placeholder="ej: juan perez">
                <label>cantidad de botellones:</label>
                <input type="number" name="cantidad_botellones" class="input-campo" min="1" required>
                <button type="submit" class="boton-enviar">enviar</button>
            </form>
        </div>
    </div>
<!-- enlace para ir al historial -->
    <div class="area-historial">
       <a href="historial.php" class="boton-historial-inicio">ver historial</a>
    </div>
</div>

</body>
</html>
