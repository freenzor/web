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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Registrados</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Pedidos Registrados</h1>
        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Cliente</th>
                    <th>Cantidad de Hallullas</th>
                    <th>Cantidad de Marraquetas</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Código PHP para obtener y mostrar los pedidos
                $result = $conn->query("SELECT * FROM pedidos");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombre_cliente']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cantidad_hallullas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cantidad_marraquetas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                    echo '<td><button class="btn btn-danger btn-sm" onclick="deleteOrder(' . htmlspecialchars($row['id']) . ')">Borrar</button></td>';
                    echo "</tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteOrder(id) {
            if (confirm('¿Está seguro de que desea borrar este pedido?')) {
                const request = new XMLHttpRequest();
                request.open('POST', 'delete_pedido.php', true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                request.onreadystatechange = function() {
                    if (request.readyState === 4 && request.status === 200) {
                        alert('Pedido borrado con éxito');
                        location.reload();
                    }
                };
                request.send(`id=${id}`);
            }
        }
    </script>
</body>
</html>
