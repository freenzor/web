<?php
session_start();

// Datos de usuarios válidos
$valid_users = [
    'admin' => 'TATO' // Usuario: admin, Contraseña: password123
];

$username = $_POST['username'];
$password = $_POST['password'];

if (isset($valid_users[$username]) && $valid_users[$username] === $password) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: pedidos.php");
    exit();
} else {
    echo "Usuario o contraseña incorrectos.";
}
?>
