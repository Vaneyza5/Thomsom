<?php
require('fpdf19/fpdf.php');  // carga la libreria fpdf para generar pdf
include('conexion.php');     // trae la conexion a la base de datos

$pdf = new FPDF();     // crea un nuevo documento pdf
$pdf->AddPage();       // agrega una pagina

// toma el filtro de busqueda desde la url
$busqueda = isset($_GET['buscar']) ? mysqli_real_escape_string($conn, $_GET['buscar']) : '';

// coloca el logo en el pdf
if (file_exists('imagenes/Logo1.png')) {
    $pdf->Image('imagenes/Logo1.png', 45, 10, 120);
} else {
    $pdf->Image('imagenes/logo1.png', 45, 10, 120);
}
$pdf->Ln(40);  // salto de linea despues del logo

// encabezados de la tabla con color de fondo
$pdf->SetFillColor(0, 90, 96);       // color de fondo verde oscuro
$pdf->SetTextColor(255, 255, 255);   // texto blanco
$pdf->SetFont('Arial', 'B', 12);     // fuente arial negrita tamano 12

$pdf->Cell(60, 10, 'cliente', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'cantidad', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'fecha', 1, 0, 'C', true);
$pdf->Ln();
// restablece colores a negro para los datos
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

// consulta sql para traer los datos
$sql = "SELECT c.nombre, ll.cantidad_botellones, ll.fecha_hora 
        FROM llenados ll 
        JOIN clientes c ON ll.cliente_id = c.id_cliente";
if (!empty($busqueda)) {
    $sql .= " WHERE c.nombre LIKE '%$busqueda%'";
}
$sql .= " ORDER BY ll.id_llenados DESC";

$lista = mysqli_query($conn, $sql);

// recorre los registros y los agrega al pdf
while ($fila = mysqli_fetch_assoc($lista)) {
    $nombre = utf8_decode($fila['nombre']);  // convierte a latin1 para el pdf
    $pdf->Cell(60, 10, $nombre, 1, 0, 'C');
    $pdf->Cell(60, 10, $fila['cantidad_botellones'], 1, 0, 'C');
    $pdf->Cell(60, 10, $fila['fecha_hora'], 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();  // envia el pdf al navegador para descargar
?>
