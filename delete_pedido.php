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

// Obtener el ID del pedido a eliminar
$id = $_POST["id"];

// Preparar la consulta SQL
$sql = "DELETE FROM pedidos WHERE id = ?";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Vincular los parámetros
$stmt->bind_param("i", $id);

// Ejecutar la declaración
if ($stmt->execute()) {
    echo "Pedido eliminado con éxito";
} else {
    echo "Error al eliminar el pedido: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
