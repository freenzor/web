<?php
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = $_POST["nombre_cliente"];
    $cantidad_hallullas = $_POST["cantidad_hallullas"];
    $cantidad_marraquetas = $_POST["cantidad_marraquetas"];
    $fecha = date("Y-m-d");

    // Preparar la consulta SQL
    $sql = "INSERT INTO pedidos (nombre_cliente, cantidad_hallullas, cantidad_marraquetas, fecha) VALUES (?, ?, ?, ?)";

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

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pedido de Pan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrar Pedido de Pan</h1>
        <form id="pedidoForm" method="POST" class="mt-4">
            <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
            </div>
            <div class="form-group">
                <label for="cantidad_hallullas">Cantidad de Hallullas:</label>
                <input type="number" class="form-control" id="cantidad_hallullas" name="cantidad_hallullas" required>
            </div>
            <div class="form-group">
                <label for="cantidad_marraquetas">Cantidad de Marraquetas:</label>
                <input type="number" class="form-control" id="cantidad_marraquetas" name="cantidad_marraquetas" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Pedido</button>
        </form>
        
        </div>
</body>
</html>
