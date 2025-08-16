<?php
require_once '../conexion/db.php';
try {
    $stmt = $pdo->query('SELECT * FROM pacientes');
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error al obtener pacientes: ' . $e->getMessage());
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
        <h1>Listar Pacientes</h1>
        <div class="row">
            <div class="col">
                <table class="table table-striped" id="tabla-pacientes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td><?= $paciente['id'] ?></td>
                                <td><?= $paciente['nombre'] ?></td>
                                <td><?= $paciente['correo'] ?></td>
                                <td><?= $paciente['telefono'] ?></td>
                                <td><?= $paciente['fecha_nacimiento'] ?></td>
                                <td>
                                    <button class='btn btn-warning btn-editar-paciente' data-id='<?= $paciente['id'] ?>'>Editar</button>
                                    <button class='btn btn-danger btn-eliminar-paciente' data-id='<?= $paciente['id'] ?>'>Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="registrar_pacientes.php" class="btn btn-primary">Registrar Nuevo Paciente</a>
                <!-- volver al inicio -->
                <a href="../index.html" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </div>
    </div> 
    <!-- Modal para editar paciente -->
    <div class="modal fade" id="modalEditarPaciente" tabindex="-1" aria-labelledby="modalEditarPacienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header border-bottom-0">
                    <h1 class="modal-title fs-4 fw-semibold" id="modalEditarPacienteLabel">Editar Paciente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarPaciente">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control bg-light" id="id" readonly>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="telefono" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-actualizar-paciente">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const modalEditarPaciente = new bootstrap.Modal(
            document.getElementById('modalEditarPaciente'), 
            {
                keyboard: false
            });
        
        var tablaPacientes = document.getElementById('tabla-pacientes');
        tablaPacientes.addEventListener('click', function(event) {
            // Botón Editar
            console.log('Click detectado en:', event.target);
            console.log('Clases del elemento:', event.target.classList);
            
            // Manejo del botón EDITAR
            if (event.target.classList.contains('btn-editar-paciente')) {
                //poner un atributo data-id al botón editar
                var id = event.target.dataset.id;
                fetch(`buscarPaciente.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                }).then(function(response) {
                    return response.json();
                }).then(function(request) {
                    // Mostrar el modal
                    modalEditarPaciente.show();
                    // Llenar los campos del modal con los datos del paciente desde el server
                    document.getElementById('id').value = request.id;
                    document.getElementById('nombre').value = request.nombre;
                    document.getElementById('correo').value = request.correo;
                    document.getElementById('telefono').value = request.telefono;
                    document.getElementById('fecha_nacimiento').value = request.fecha_nacimiento;
                });
            }
            
            // Manejo del botón ELIMINAR
            if (event.target.classList.contains('btn-eliminar-paciente')) {
                
                var id = event.target.dataset.id;
                var fila = event.target.closest('tr'); // Obtener la fila del paciente
                var nombre = fila.cells[1].textContent; // Obtener el nombre del paciente desde la fila
                // Mostrar alerta de confirmación
                Swal.fire({
                    title: `¿Está seguro de eliminar al paciente "${nombre}"?`,
                    text: nombre,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'Cancelar Eliminación'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar petición para eliminar
                        fetch('eliminarPaciente.php', {
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
                                    `El paciente ${nombre} fue eliminado correctamente.`,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'No se pudo eliminar el paciente.',
                                    'error'
                                );
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error',
                                'Ocurrió un error al eliminar el paciente.',
                                'error'
                            );
                        });
                    }
                });
            }
        });

        //codigo para actualizar el paciente
        var btnActualizarPaciente = document.getElementById('btn-actualizar-paciente');
        btnActualizarPaciente.addEventListener('click', function() {
            let id = document.getElementById('id').value;
            let nombre = document.getElementById('nombre').value;
            let correo = document.getElementById('correo').value;
            let telefono = document.getElementById('telefono').value;
            let fecha_nacimiento = document.getElementById('fecha_nacimiento').value;

            // Validar que los campos no estén vacíos
            if (!nombre || !correo || !telefono || !fecha_nacimiento) {
                Swal.fire(
                    'Error!',
                    'Todos los campos son obligatorios.',
                    'error'
                );
                return;
            }

            fetch('actualizarPacientes.php', {
                method: 'POST',
                headers: {
                        'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    id: id, 
                    nombre: nombre, 
                    correo: correo, 
                    telefono: telefono, 
                    fecha_nacimiento: fecha_nacimiento 
                })
            }).then(function(response) {
                if(!response.ok) {
                    throw new Error('Error en la petición de actualización');
                }   
                    return response.json();
            }).then(function(data) {
                if(data.success){
                    modalEditarPaciente.hide();
                        Swal.fire(
                            'Actualizado!',
                            'El paciente ha sido actualizado correctamente.',
                            'success'
                        ).then(() => location.reload());
                }else{
                    Swal.fire(
                            'Error!',
                            data.message || 'No se pudo actualizar el paciente.',
                            'error'
                    );
                }
            }).catch(function(error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Ocurrió un error al actualizar el paciente.',
                    'error'
                );
            });
        });
    </script>
</body>
</html>