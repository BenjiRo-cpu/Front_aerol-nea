<?php
// Establecer la cabecera para devolver JSON (opcional, dependiendo de cómo manejes las respuestas)
header('Content-Type: application/json');

// Configuración de la base de datos usando las variables de entorno que has configurado en Railway
$host = getenv('MYSQLHOST');
$database = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    // Enviar un error en formato JSON si la conexión falla
    echo json_encode(["error" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Si la conexión es exitosa, puedes devolver un mensaje de éxito
echo json_encode(["status" => "Conexión exitosa"]);
?>
