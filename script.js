// Capturamos el formulario por su ID y le agregamos un evento para cuando se envíe
document.getElementById('buscar-vuelos').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene el envío de formulario y recarga de la página

    // Captura los datos del formulario
    const origen = document.getElementById('origen').value;
    const destino = document.getElementById('destino').value;
    const fecha = document.getElementById('fecha').value;

    // Validación básica de datos
    if (!origen || !destino || !fecha) {
        alert('Por favor, completa todos los campos.');
        if (!origen) document.getElementById('origen').focus();
        else if (!destino) document.getElementById('destino').focus();
        else if (!fecha) document.getElementById('fecha').focus();
        return;
    }

    // Enviar los datos al backend usando fetch
    fetch('buscar_vuelos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `origen=${encodeURIComponent(origen)}&destino=${encodeURIComponent(destino)}&fecha=${encodeURIComponent(fecha)}`
    })
    .then(response => response.json())
    .then(resultados => {
        // Mostrar los resultados en la página
        mostrarResultados(origen, destino, fecha, resultados);
    })
    .catch(error => {
        console.error('Error al realizar la búsqueda:', error);
        alert('Hubo un problema al realizar la búsqueda de vuelos. Por favor, intenta nuevamente.');
    });

    // Limpiar el formulario después de la búsqueda
    document.getElementById('buscar-vuelos').reset();
});

// Función para mostrar los resultados en la página
function mostrarResultados(origen, destino, fecha, resultados) {
    // Selecciona el contenedor de resultados
    const contenedorResultados = document.getElementById('resultados-busqueda');
    
    // Limpia cualquier resultado previo
    contenedorResultados.innerHTML = `<h3>Vuelos disponibles de ${origen} a ${destino} el ${fecha}</h3>`;

    // Si hay resultados, los mostramos; si no, mostramos un mensaje de "No hay vuelos"
    if (resultados.length > 0) {
        resultados.forEach(vuelo => {
            const vueloInfo = document.createElement('div');
            vueloInfo.classList.add('resultado-vuelo');
            vueloInfo.innerHTML = `
                <p><strong>Número de Vuelo:</strong> ${vuelo.numeroVuelo}</p>
                <p><strong>Salida:</strong> ${vuelo.horaSalida}</p>
                <p><strong>Llegada:</strong> ${vuelo.horaLlegada}</p>
                <p><strong>Precio:</strong> $${vuelo.precio} MXN</p>
                <button onclick="reservarVuelo('${vuelo.numeroVuelo}')">Reservar</button>
            `;
            contenedorResultados.appendChild(vueloInfo);
        });
    } else {
        contenedorResultados.innerHTML += `<p>No hay vuelos disponibles para la fecha seleccionada.</p>`;
    }
}

// Función para simular la reserva de un vuelo
function reservarVuelo(numeroVuelo) {
    alert(`Has reservado el vuelo ${numeroVuelo}. ¡Gracias por elegir Aerolínea Benjiro!`);
}
