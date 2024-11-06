<?php
// Establecer la cabecera para devolver JSON (opcional, dependiendo de cómo manejes las respuestas)
header('Content-Type: application/json');

// Configuración de la base de datos en Railway
$host = "autorack.proxy.rlwy.net";
$database = "railway";
$user = "root";
$password = "jTkQUOKnFggBChnTHtPNEtTmuaJisuBx";
$port = 3306;

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    // Enviar un error en formato JSON si la conexión falla
    echo json_encode(["error" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Si la conexión es exitosa, no es necesario hacer nada más aquí
?>
