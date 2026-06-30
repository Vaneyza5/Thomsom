<?php
include('conexion.php');  // trae la conexion a la base de datos

// toma el texto de busqueda si el formulario se envio
$busqueda = isset($_POST['buscar']) ? mysqli_real_escape_string($conn, $_POST['buscar']) : '';

// consulta sql para traer los llenados junto con el nombre del cliente
$sql = "SELECT ll.id_llenados, c.nombre, ll.cantidad_botellones, ll.fecha_hora 
        FROM llenados ll 
        JOIN clientes c ON ll.cliente_id = c.id_cliente";
// si hay busqueda, filtra por nombre
if (!empty($busqueda)) {
    $sql .= " WHERE c.nombre LIKE '%$busqueda%'";
}
// ordena del mas reciente al mas antiguo
$sql .= " ORDER BY ll.id_llenados DESC";
// ejecuta la consulta
$lista = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>historial de llenados</title>
    <link rel="stylesheet" href="estilosc/estilos.css">
</head>
<body>

<!-- boton para volver al panel principal -->
<div class="contenedor-volver">
    <button class="boton-volver" onclick="window.location.href='principal.php';">
        ← volver al panel
    </button>
</div>

<div class="contenedor-tabla">
    <h1 class="titulo-principal">historial de llenados</h1>

<!-- barra de herramientas con botones y buscador -->
<div class="barra-herramientas">
    <!-- botones a la izquierda -->
    <div class="bloque-izquierdo">
        <a href="index.php" class="boton-accion">volver al registro</a>
        <a href="reporte.php?buscar=<?php echo urlencode($busqueda); ?>" class="boton-accion">descargar pdf</a>
    </div>
    <!-- formulario de busqueda a la derecha -->
    <form method="POST" action="historial.php" class="bloque-derecho">
        <input class="input-campo" type="text" name="buscar" placeholder="buscar por nombre..." 
               value="<?php echo htmlspecialchars($busqueda); ?>">
        
        <button type="submit" class="boton-accion">buscar</button>
        <a href="historial.php" class="boton-accion" style="text-decoration: none;">limpiar</a>
    </form>
</div>

<!-- tabla que muestra el historial -->
    <table class="tabla-historial">
        <thead>
            <tr>
                <th>cliente</th>
                <th>cantidad</th>
                <th>fecha y hora</th>
                <th>eliminar</th>
            </tr>
        </thead>
        <tbody>
    <?php
    // recorre cada registro y lo muestra en una fila de la tabla
    while($fila = mysqli_fetch_assoc($lista)):
    ?>
    <tr>
        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
        <td><?php echo htmlspecialchars($fila['cantidad_botellones']); ?></td>
        <td><?php echo htmlspecialchars($fila['fecha_hora']); ?></td>
        <td>
            <!-- enlace para eliminar el registro con confirmacion -->
            <a href="eliminar.php?id=<?php echo $fila['id_llenados']; ?>" onclick="return confirm('estas seguro de eliminar este registro?');">
    <img src="imagenes/basura.png" alt="eliminar" style="width: 25px; height: 25px; vertical-align: middle;">
</a>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>
    </table>
</div>

</body>
</html>
