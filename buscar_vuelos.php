<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Establecer la cabecera para devolver JSON
header('Content-Type: application/json');

// Verificar si los datos fueron enviados como JSON (método POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos JSON de la solicitud
    $inputData = file_get_contents("php://input");
    
    // Decodificar el JSON a un array de PHP
    $data = json_decode($inputData, true);  // El segundo parámetro 'true' convierte a array asociativo

    // Verificar si los datos JSON están bien formateados
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["error" => "Error en el formato JSON."]);
        exit;
    }

    // Validar que los campos necesarios estén presentes en los datos decodificados
    if (isset($data['origen'], $data['destino'], $data['fecha']) && 
        !empty($data['origen']) && !empty($data['destino']) && !empty($data['fecha'])) {

        // Sanitizar los datos
        $origen = trim($data['origen']);
        $destino = trim($data['destino']);
        $fecha = trim($data['fecha']);

        // Validar que la fecha esté en el formato correcto (YYYY-MM-DD)
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
            echo json_encode(["error" => "El formato de la fecha no es válido. Debe ser YYYY-MM-DD."]);
            exit;
        }

        // Preparar y ejecutar la consulta
        $sql = "SELECT * FROM vuelos WHERE Origen = ? AND Destino = ? AND Fecha_Salida = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sss', $origen, $destino, $fecha);

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

                // Si no hay resultados
                if (empty($vuelos)) {
                    echo json_encode(["mensaje" => "No se encontraron vuelos para los criterios especificados."]);
                } else {
                    // Enviar los resultados en formato JSON al front-end
                    echo json_encode($vuelos);
                }

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
        // Datos incompletos o vacíos
        echo json_encode(["error" => "Datos incompletos o vacíos."]);
    }
} else {
    // Método de solicitud no permitido
    echo json_encode(["error" => "Método de solicitud no permitido."]);
}
?>

