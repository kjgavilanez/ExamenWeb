// citas_utils.js
// Funciones para calcular duración y costo total de citas

function calcularDuracionYCosto(tarifasMedicos) {
    const inicio = document.getElementById('hora_inicio').value;
    const fin = document.getElementById('hora_fin').value;
    const medicoId = document.getElementById('medico_id').value;
    let duracion = 0;
    if (inicio && fin) {
        const [h1, m1] = inicio.split(':').map(Number);
        const [h2, m2] = fin.split(':').map(Number);
        const minutosInicio = h1 * 60 + m1;
        const minutosFin = h2 * 60 + m2;
        duracion = minutosFin - minutosInicio;
        document.getElementById('duracion').value = duracion > 0 ? duracion : 0;
    } else {
        document.getElementById('duracion').value = '';
    }
    // Calcular costo total
    if (medicoId && duracion > 0 && tarifasMedicos[medicoId]) {
        const tarifa = tarifasMedicos[medicoId];
        const costo = (tarifa * duracion) / 60;
        document.getElementById('costo_total').value = costo.toFixed(2);
    } else {
        document.getElementById('costo_total').value = '';
    }
}

function agregarListenersCita(tarifasMedicos) {
    document.getElementById('hora_inicio').addEventListener('change', function() {
        calcularDuracionYCosto(tarifasMedicos);
    });
    document.getElementById('hora_fin').addEventListener('change', function() {
        calcularDuracionYCosto(tarifasMedicos);
    });
    document.getElementById('medico_id').addEventListener('change', function() {
        calcularDuracionYCosto(tarifasMedicos);
    });
}
