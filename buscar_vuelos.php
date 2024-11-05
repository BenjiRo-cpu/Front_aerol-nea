<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Establecer la cabecera para devolver JSON
header('Content-Type: application/json');

// Verificar si los datos fueron enviados desde el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar que los campos necesarios estén presentes
    if (isset($_POST['origen'], $_POST['destino'], $_POST['fecha'])) {
        // Recibir y sanitizar los datos del formulario
        $origen = trim($_POST['origen']);
        $destino = trim($_POST['destino']);
        $fecha = trim($_POST['fecha']);

        // Preparar y ejecutar la consulta
        $sql = "SELECT * FROM vuelos WHERE Origen = ? AND Destino = ? AND Fecha_Salida = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $origen, $destino, $fecha);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $vuelos = [];

                // Recopilar los resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $vuelos[] = [
                            "numeroVuelo" => $row['Número_Vuelo'],
                            "horaSalida" => $row['Hora_Salida'], // Asegúrate de que este campo exista
                            "horaLlegada" => $row['Hora_Llegada'], // Asegúrate de que este campo exista
                            "precio" => $row['Precio']
                        ];
                    }
                }

                // Enviar los resultados en formato JSON al front-end
                echo json_encode($vuelos);
            } else {
                // Error en la ejecución de la consulta
                echo json_encode(["error" => "Error en la ejecución de la consulta: " . $stmt->error]);
            }

            // Cerrar la consulta
            $stmt->close();
        } else {
            // Error al preparar la consulta
            echo json_encode(["error" => "Error al preparar la consulta: " . $conn->error]);
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        // Datos incompletos
        echo json_encode(["error" => "Datos incompletos."]);
    }
} else {
    // Método de solicitud no permitido
    echo json_encode(["error" => "Método de solicitud no permitido."]);
}
?>
