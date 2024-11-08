<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerolínea Benjíro - La Más Perrona</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Encabezado / Navbar -->
    <header>
        <h1>Aerolínea Benjíro - La Más Perrona</h1>
        <nav>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#buscar-vuelos">Buscar Vuelos</a></li>
                <li><a href="#reservas">Mis Reservas</a></li>
                <li><a href="#admin">Administración</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sección de Inicio -->
    <section id="inicio">
        <h2>Bienvenido a Aerolínea Benjíro</h2>
        <p>Viaja con comodidad y estilo con "La Más Perrona". Explora nuestros vuelos, realiza reservaciones y disfruta de un servicio premium.</p>
    </section>

    <!-- Sección de Buscar Vuelos -->
    <section id="buscar-vuelos">
        <h2>Buscar Vuelos</h2>
        <form id="form-buscar-vuelos">
            <label for="origen">Origen:</label>
            <input type="text" id="origen" name="origen" placeholder="Ej. Ciudad de México" required>
            
            <label for="destino">Destino:</label>
            <input type="text" id="destino" name="destino" placeholder="Ej. Cancún" required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <button type="submit">Buscar</button>
        </form>
        <div id="resultados-busqueda"></div>
    </section>

    <!-- Sección de Mis Reservas -->
    <section id="reservas">
        <h2>Mis Reservas</h2>
        <p>Inicia sesión para ver tus reservas.</p>
    </section>

    <!-- Sección de Administración -->
    <section id="admin">
        <h2>Administración</h2>
        <p>Panel exclusivo para empleados de la aerolínea.</p>
    </section>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 Aerolínea Benjíro - La Más Perrona</p>
    </footer>

    <!-- Script para manejar la búsqueda y mostrar resultados -->
    <script>
        document.getElementById('form-buscar-vuelos').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const origen = document.getElementById('origen').value;
            const destino = document.getElementById('destino').value;
            const fecha = document.getElementById('fecha').value;
            
            // Hacer una petición AJAX a buscar_vuelos.php
            fetch('buscar_vuelos.php', {
                method: 'POST',
                headers: ({
                    'Content-Type': 'application/json'
                }),
                body: JSON.stringify({ origen, destino, fecha })
            })
            .then(response => response.json())
            .then(data => {
            console.log(data);
                const resultadosDiv = document.getElementById('resultados-busqueda');
                resultadosDiv.innerHTML = ''; // Limpiar resultados anteriores

                if (data.length > 0) {
                    data.forEach(vuelo => {
                        const vueloDiv = document.createElement('div');
                        vueloDiv.classList.add('resultado-vuelo');
                        vueloDiv.innerHTML = `
                            <p><strong>Origen:</strong> ${vuelo.origen}</p>
                            <p><strong>Destino:</strong> ${vuelo.destino}</p>
                            <p><strong>Fecha:</strong> ${vuelo.fecha}</p>
                            <p><strong>Precio:</strong> ${vuelo.precio}</p>
                        `;
                        resultadosDiv.appendChild(vueloDiv);
                    });
                } else {
                    resultadosDiv.innerHTML = '<p>No se encontraron vuelos para los criterios especificados.</p>';
                }
            })
            .catch(error => {
                console.error('Error al buscar vuelos:', error);
                document.getElementById('resultados-busqueda').innerHTML = '<p>Ocurrió un error al buscar vuelos. Por favor intenta de nuevo.</p>';
            });
        });
    </script>
</body>
</html>
