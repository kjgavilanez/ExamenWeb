<?php
require_once '../conexion/db.php';
try {
    $stmt = $pdo->query('SELECT * FROM medicos');
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error al obtener medicos: ' . $e->getMessage());
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
        <h1 class="mb-4 text-center fw-bold">Listar Médicos</h1>
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0" id="tabla-medicos">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Tarifa por Hora</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicos as $medico): ?>
                            <tr>
                                <td class="text-center"><?= $medico['id'] ?></td>
                                <td><?= $medico['nombre'] ?></td>
                                <td><?= $medico['especialidad'] ?></td>
                                <td><?= $medico['tarifa_por_hora'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm px-3 btn-editar-medico" data-id="<?= $medico['id'] ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm px-3 btn-eliminar-medico" data-id="<?= $medico['id'] ?>">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="registrar_medicos.php" class="btn btn-primary px-4">Registrar Nuevo Médico</a>
            <a href="../index.html" class="btn btn-outline-secondary px-4">Volver al Inicio</a>
        </div>
    </div>

    <div class="modal fade" id="modalEditarMedico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel">Editar Médico</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id" class="form-label fw-semibold">ID</label>
                        <input type="text" class="form-control" id="id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="especialidad" class="form-label fw-semibold">Especialidad</label>
                        <input type="text" class="form-control" id="especialidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="tarifa_por_hora" class="form-label fw-semibold">Tarifa por Hora</label>
                        <input type="number" class="form-control" id="tarifa_por_hora" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-actualizar-medico">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const modalEditarMedico = new bootstrap.Modal(
            document.getElementById('modalEditarMedico'), 
            {
                keyboard: false
            });
        
        var tablaMedicos = document.getElementById('tabla-medicos');
        tablaMedicos.addEventListener('click', function(event) {
            // Botón Editar
            console.log('Click detectado en:', event.target);
            console.log('Clases del elemento:', event.target.classList);
            
            // Manejo del botón EDITAR
            if (event.target.classList.contains('btn-editar-medico')) {
                //poner un atributo data-id al botón editar
                var id = event.target.dataset.id;
                fetch(`buscarMedico.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                }).then(function(response) {
                    return response.json();
                }).then(function(request) {
                    // Mostrar el modal
                    modalEditarMedico.show();
                    // Llenar los campos del modal con los datos del medico desde el server
                    document.getElementById('id').value = request.id;
                    document.getElementById('nombre').value = request.nombre;
                    document.getElementById('especialidad').value = request.especialidad;
                    document.getElementById('tarifa_por_hora').value = request.tarifa_por_hora;
                });
            }
            
            // Manejo del botón ELIMINAR
            if (event.target.classList.contains('btn-eliminar-medico')) {
                
                var id = event.target.dataset.id;
                var fila = event.target.closest('tr'); // Obtener la fila del medico
                var nombre = fila.cells[1].textContent; // Obtener el nombre del medico desde la fila
                // Mostrar alerta de confirmación
                Swal.fire({
                    title: `¿Está seguro de eliminar al medico "${nombre}"?`,
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
                        fetch('eliminarMedico.php', {
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
                                    'El médico fue eliminado correctamente.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'No se pudo eliminar el médico.',
                                    'error'
                                );
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error',
                                'Ocurrió un error al eliminar el médico.',
                                'error'
                            );
                        });
                    }
                });
            }
        });

        //codigo para actualizar el medico
        var btnActualizarMedico = document.getElementById('btn-actualizar-medico');
        btnActualizarMedico.addEventListener('click', function() {
            let id = document.getElementById('id').value;
            let nombre = document.getElementById('nombre').value;
            let especialidad = document.getElementById('especialidad').value;
            let tarifa_por_hora = document.getElementById('tarifa_por_hora').value;

            // Validar que los campos no estén vacíos
            if (!nombre || !especialidad || !tarifa_por_hora) {
                Swal.fire(
                    'Error!',
                    'Todos los campos son obligatorios.',
                    'error'
                );
                return;
            }

            fetch('actualizarMedicos.php', {
                method: 'POST',
                headers: {
                        'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    id: id, 
                    nombre: nombre, 
                    especialidad: especialidad, 
                    tarifa_por_hora: tarifa_por_hora
                })
            }).then(function(response) {
                if(!response.ok) {
                    throw new Error('Error en la petición de actualización');
                }   
                    return response.json();
            }).then(function(data) {
                if(data.success){
                    modalEditarMedico.hide();
                    Swal.fire(
                        'Actualizado!',
                        'El médico ha sido actualizado correctamente.',
                        'success'
                    ).then(() => location.reload());
                }else{
                    Swal.fire(
                        'Error!',
                        data.message || 'No se pudo actualizar el médico.',
                        'error'
                    );
                }
            }).catch(function(error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Ocurrió un error al actualizar el médico.',
                    'error'
                );
            });
        });
    </script>
</body>
</html>