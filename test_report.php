<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Test 1: PHP funciona</h2>";

echo "<h2>Test 2: Cargando FPDF...</h2>";
require('fpdf19/fpdf.php');
echo "OK - FPDF cargado<br>";

echo "<h2>Test 3: Version PHP</h2>";
echo phpversion() . "<br>";

echo "<h2>Test 4: Extensiones</h2>";
echo "mbstring: " . (extension_loaded('mbstring') ? 'SI' : 'NO') . "<br>";
echo "iconv: " . (extension_loaded('iconv') ? 'SI' : 'NO') . "<br>";
echo "gd: " . (extension_loaded('gd') ? 'SI' : 'NO') . "<br>";

echo "<h2>Test 5: Creando PDF...</h2>";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Prueba OK');
echo "PDF creado exitosamente<br>";

echo "<h2>Test 6: Buscando logo...</h2>";
if (file_exists('imagenes/Logo1.png')) {
    echo "Logo1.png (mayuscula) EXISTE<br>";
} else {
    echo "Logo1.png NO existe<br>";
}
if (file_exists('imagenes/logo1.png')) {
    echo "logo1.png (minuscula) EXISTE<br>";
} else {
    echo "logo1.png NO existe<br>";
}

echo "<h2>Test 7: Conexion BD...</h2>";
include('conexion.php');
echo "Conexion OK<br>";

echo "<h2>Test 8: Consulta...</h2>";
$sql = "SELECT c.nombre, ll.cantidad_botellones, ll.fecha_hora 
        FROM llenados ll 
        JOIN clientes c ON ll.cliente_id = c.id_cliente 
        ORDER BY ll.id_llenados DESC LIMIT 1";
$r = mysqli_query($conn, $sql);
if ($r) {
    echo "Consulta OK, registros: " . mysqli_num_rows($r) . "<br>";
} else {
    echo "Error consulta: " . mysqli_error($conn) . "<br>";
}
