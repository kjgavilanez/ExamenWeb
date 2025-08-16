<?php
require_once '../conexion/db.php';
try {
    $stmt = $pdo->query('SELECT * FROM citas');
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error al obtener citas: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pacientes</title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%); min-height:100vh; font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #fff;">
                    <div class="mb-4">
                        <h1 class="mb-0 text-center" style="font-weight:700; letter-spacing:1px; color:#2d3748;">Listar Citas</h1>
                    </div>
                    <div class="table-responsive rounded-3 shadow-sm">
                        <table class="table table-hover align-middle mb-0" id="tabla-citas" style="background:#f8fafc; border-radius:12px; overflow:hidden;">
                            <thead class="table-light" style="font-size:1.05rem;">
                                <tr>
                                    <th class="fw-semibold text-center">ID</th>
                                    <th class="fw-semibold text-center">Paciente ID</th>
                                    <th class="fw-semibold text-center">Médico ID</th>
                                    <th class="fw-semibold text-center">Fecha</th>
                                    <th class="fw-semibold text-center">Hora de Inicio</th>
                                    <th class="fw-semibold text-center">Hora de Fin</th>
                                    <th class="fw-semibold text-center">Duración</th>
                                    <th class="fw-semibold text-center">Costo Total</th>
                                    <th class="fw-semibold text-center">Estado</th>
                                    <th class="fw-semibold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($citas as $cita): ?>
                                    <tr style="transition:background 0.2s;">
                                        <td class="text-center"><?= $cita['id'] ?></td>
                                        <td class="text-center"><?= $cita['paciente_id'] ?></td>
                                        <td class="text-center"><?= $cita['medico_id'] ?></td>
                                        <td class="text-center"><?= $cita['fecha'] ?></td>
                                        <td class="text-center"><?= $cita['hora_inicio'] ?></td>
                                        <td class="text-center"><?= $cita['hora_fin'] ?></td>
                                        <td class="text-center"><?= $cita['duracion'] ?></td>
                                        <td class="text-center"><?= $cita['costo_total'] ?></td>
                                        <td class="text-center"><?= $cita['estado'] ?></td>
                                        <td class="text-center">
                                            <button class='btn btn-warning btn-editar-cita btn-sm px-3 me-1' data-id='<?= $cita['id'] ?>' style="border-radius:8px; font-weight:500;">Editar</button>
                                            <button class='btn btn-danger btn-eliminar-cita btn-sm px-3' data-id='<?= $cita['id'] ?>' style="border-radius:8px; font-weight:500;">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="registrar_citas.php" class="btn btn-primary btn-lg px-4" style="border-radius:8px; font-weight:500;">Registrar Nueva Cita</a>
                        <a href="consultas_citas.php" class="btn btn-outline-secondary btn-lg px-4" style="border-radius:8px; font-weight:500;">Consultar Citas</a>
                        <a href="../index.html" class="btn btn-outline-secondary btn-lg px-4" style="border-radius:8px; font-weight:500;">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-weight:600;">Editar Cita</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="mb-3">
                    <label for="id" class="form-label fw-semibold">ID</label>
                    <input type="text" class="form-control" id="id" readonly style="background:#f1f5f9;">
                </div>

                <div class="mb-3">
                    <label for="paciente_id" class="form-label fw-semibold">Paciente ID</label>
                    <input type="text" class="form-control" id="paciente_id" required>
                </div>

                <div class="mb-3">
                    <label for="medico_id" class="form-label fw-semibold">Médico ID</label>
                    <input type="text" class="form-control" id="medico_id" required>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label fw-semibold">Fecha</label>
                    <input type="date" class="form-control" id="fecha" required>
                </div>

                <div class="mb-3">
                    <label for="hora_inicio" class="form-label fw-semibold">Hora de Inicio</label>
                    <input type="time" class="form-control" id="hora_inicio" required>
                </div>

                <div class="mb-3">
                    <label for="hora_fin" class="form-label fw-semibold">Hora de Fin</label>
                    <input type="time" class="form-control" id="hora_fin" required>
                </div>

                <div class="mb-3">
                    <label for="duracion" class="form-label fw-semibold">Duración (minutos)</label>
                    <input type="number" class="form-control" id="duracion" required>
                </div>

                <div class="mb-3">
                    <label for="costo_total" class="form-label fw-semibold">Costo Total</label>
                    <input type="number" step="0.01" class="form-control" id="costo_total" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label fw-semibold">Estado</label>
                    <input type="text" class="form-control" id="estado" required>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius:8px; font-weight:500;">Cancelar</button>
                <button type="button" class="btn btn-primary px-4" id="btn-actualizar-cita" style="border-radius:8px; font-weight:500;">Actualizar</button>
            </div>
            </div>
        </div>
    </div>
    <script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const modalEditarCita = new bootstrap.Modal(
            document.getElementById('modalEditarCita'), 
            {
                keyboard: false
            });

        var tablaCitas = document.getElementById('tabla-citas');
        tablaCitas.addEventListener('click', function(event) {
            // Botón Editar
            console.log('Click detectado en:', event.target);
            console.log('Clases del elemento:', event.target.classList);
            
            // Manejo del botón EDITAR
            if (event.target.classList.contains('btn-editar-cita')) {
                //poner un atributo data-id al botón editar
                var id = event.target.dataset.id;
                fetch(`buscarCita.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                }).then(function(response) {
                    return response.json();
                }).then(function(request) {
                    // Mostrar el modal
                    modalEditarCita.show();
                    // Llenar los campos del modal con los datos de la cita desde el server
                    document.getElementById('id').value = request.id;
                    document.getElementById('paciente_id').value = request.paciente_id;
                    document.getElementById('medico_id').value = request.medico_id;
                    document.getElementById('fecha').value = request.fecha;
                    document.getElementById('hora_inicio').value = request.hora_inicio;
                    document.getElementById('hora_fin').value = request.hora_fin;
                    document.getElementById('duracion').value = request.duracion;
                    document.getElementById('costo_total').value = request.costo_total;
                    document.getElementById('estado').value = request.estado;
                    // Calcular duración y costo
                    calcularDuracionYCosto(tarifasMedicos);
                });
            }
            
            // Manejo del botón ELIMINAR
            if (event.target.classList.contains('btn-eliminar-cita')) {

                var id = event.target.dataset.id;
                var fila = event.target.closest('tr'); // Obtener la fila de la cita
                var nombre = fila.children[1].textContent; // Suponiendo que el nombre está en la segunda columna
                Swal.fire({
                    title: `¿Está seguro de eliminar la cita "${id}"?`,
                    text: id,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar petición para eliminar
                        fetch('eliminarCita.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: id })
                        }).then(response =>{
                            if (!response.ok) {
                                throw new Error('Error en la petición de eliminación');
                            }
                            return response.json();
                        }).then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Eliminado',
                                    `La cita ${id} fue eliminada correctamente.`,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'No se pudo eliminar la cita.',
                                    'error'
                                );
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error',
                                'Ocurrió un error al eliminar la cita.',
                                'error'
                            );
                        });
                    }
                });
            }
        });

        //codigo para actualizar la cita
        var btnActualizarCita = document.getElementById('btn-actualizar-cita');
        btnActualizarCita.addEventListener('click', function() {
            let id = document.getElementById('id').value;
            let paciente_id = document.getElementById('paciente_id').value;
            let medico_id = document.getElementById('medico_id').value;
            let fecha = document.getElementById('fecha').value;
            let hora_inicio = document.getElementById('hora_inicio').value;
            let hora_fin = document.getElementById('hora_fin').value;
            let duracion = document.getElementById('duracion').value;
            let costo_total = document.getElementById('costo_total').value;
            let estado = document.getElementById('estado').value;

            // Validar que los campos no estén vacíos
            if (!paciente_id || !medico_id || !fecha || !hora_inicio || !hora_fin || !duracion || !costo_total || !estado) {
                Swal.fire(
                    'Error!',
                    'Todos los campos son obligatorios.',
                    'error'
                );
                return;
            }

            fetch('actualizarCita.php', {
                method: 'POST',
                headers: {
                        'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    id: id, 
                    paciente_id: paciente_id,
                    medico_id: medico_id,
                    fecha: fecha,
                    hora_inicio: hora_inicio,
                    hora_fin: hora_fin,
                    duracion: duracion,
                    costo_total: costo_total,
                    estado: estado
                })
            }).then(function(response) {
                if(!response.ok) {
                    throw new Error('Error en la petición de actualización');
                }   
                    return response.json();
            }).then(function(data) {
                if(data.success){
                    modalEditarCita.hide();
                    Swal.fire(
                        'Actualizado!',
                        'La cita ha sido actualizada correctamente.',
                        'success'
                    ).then(() => location.reload());
                }else{
                    Swal.fire(
                        'Error!',
                        data.message || 'No se pudo actualizar la cita.',
                        'error'
                    );
                }
            }).catch(function(error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Ocurrió un error al actualizar la cita.',
                    'error'
                );
            });
        });
    </script>
    <script>
        // Guardar tarifas de médicos en JS
        const tarifasMedicos = {};
        <?php
        $medicos = $pdo->query('SELECT id, tarifa_por_hora FROM medicos')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($medicos as $medico) {
            echo "tarifasMedicos[{$medico['id']}] = {$medico['tarifa_por_hora']};\n";
        }
        ?>
    </script>
    <script src="../public/js/citas_utils.js"></script>
    <script>
        agregarListenersCita(tarifasMedicos);

        // Cuando abras el modal de edición, después de llenar los campos, llama:
        // calcularDuracionYCosto(tarifasMedicos);
        // Ejemplo:
        // document.getElementById('hora_inicio').value = ...;
        // document.getElementById('hora_fin').value = ...;
        // document.getElementById('medico_id').value = ...;
        // calcularDuracionYCosto(tarifasMedicos);
    </script>
</body>
</html>