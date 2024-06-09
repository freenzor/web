<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Coloca la contraseña de tu base de datos aquí
$dbname = "panaderia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre_cliente = $_POST["nombre_cliente"];
$cantidad_hallullas = $_POST["cantidad_hallullas"];
$cantidad_marraquetas = $_POST["cantidad_marraquetas"];
$fecha = date("Y-m-d");

// Preparar la consulta SQL
$sql ="INSERT INTO pedidos (nombre_cliente, cantidad_hallullas, cantidad_marraquetas, fecha) VALUES (?, ?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Vincular los parámetros
$stmt->bind_param("siis", $nombre_cliente, $cantidad_hallullas, $cantidad_marraquetas, $fecha);

// Ejecutar la declaración
if ($stmt->execute()) {
    echo "Datos insertados con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
